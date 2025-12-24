<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Artwork;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Schema;
use Illuminate\Pagination\LengthAwarePaginator;

class ProfileController extends Controller
{
    public function show($identifier, Request $request)
    {
        // allow either numeric id or username as identifier
        if (is_numeric($identifier)) {
            // use find() so we can handle missing user with a friendly page and logging (instead of throwing)
            $user = User::find($identifier);
            if (!$user) {
                \Log::warning('Profile lookup failed (numeric id)', ['identifier' => $identifier, 'auth_id' => Auth::id()]);
                $authUser = Auth::user();
                return response()->view('errors.profile_not_found', ['identifier' => $identifier, 'authUser' => $authUser], 404);
            }
        } else {
            // tolerant username lookup to avoid 404s caused by encoding, dashes/spaces, or case differences
            $decoded = rawurldecode($identifier);
            $alt = str_replace('-', ' ', $decoded);
            $lower = mb_strtolower($decoded);

            $user = User::where('username', $decoded)
                ->orWhere('username', $alt)
                ->orWhereRaw('lower(username) = ?', [$lower])
                ->first();

            if (!$user) {
                // last attempt: try direct equal (falls back to original behaviour)
                $user = User::where('username', $identifier)->first();
            }

            if (!$user) {
                // Log diagnostic info to help debug 404s originating from profile links
                \Log::warning('Profile lookup failed (username)', ['identifier' => $identifier, 'auth_id' => Auth::id()]);

                $authUser = Auth::user();
                return response()->view('errors.profile_not_found', ['identifier' => $identifier, 'authUser' => $authUser], 404);
            }
        }

        $category = $request->get('category');

        // If artworks table doesn't exist (eg tests without migrations), return an empty paginator
        if (Schema::hasTable('artworks')) {
            // include user on artworks so templates can reference creator info without extra queries
            $artworks = $user->artworks()->with('category', 'user')
                ->when($category, function ($q, $category) {
                    $q->whereHas('category', fn($q2) => $q2->where('slug', $category));
                })
                ->latest()->paginate(12);

            // liked and saved lists for this user (for profile tabs)
            $liked = $user->likedArtworks()->with('category','user')->latest()->paginate(12, ['*'], 'liked_page');
            $saved = $user->savedArtworks()->with('category','user')->latest()->paginate(12, ['*'], 'saved_page');
        } else {
            $artworks = new LengthAwarePaginator([], 0, 12, 1, [
                'path' => $request->url(),
                'query' => $request->query(),
            ]);
            $liked = new LengthAwarePaginator([], 0, 12, 1, ['path' => $request->url(), 'query' => $request->query()]);
            $saved = new LengthAwarePaginator([], 0, 12, 1, ['path' => $request->url(), 'query' => $request->query()]);
        }

        $categories = Schema::hasTable('categories') ? Category::all() : collect();

        // articles authored by this user
        if (Schema::hasTable('articles')) {
            $articles = $user->articles()->latest()->paginate(6);
        } else {
            $articles = new LengthAwarePaginator([], 0, 6, 1, ['path' => $request->url(), 'query' => $request->query()]);
        }

        // Followers/following counts - guard against missing follows table
        if (Schema::hasTable('follows')) {
            $followersCount = $user->followers()->count();
            $followingCount = $user->following()->count();
            $isFollowing = Auth::check() ? Auth::user()->following()->where('followed_id', $user->id)->exists() : false;
        } else {
            $followersCount = 0;
            $followingCount = 0;
            $isFollowing = false;
        }

        return view('profile.show', compact('user', 'artworks', 'categories', 'isFollowing', 'followersCount', 'followingCount', 'liked', 'saved', 'articles'));
    }

    
    public function edit()
    {
        $user = Auth::user();
        $categories = Category::all();
        return view('profile.edit', compact('user', 'categories'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $data = $request->validate([
            'first_name' => 'nullable|string|max:50',
            'last_name' => 'nullable|string|max:50',
            'username' => 'required|string|max:50|unique:users,username,'.$user->id,
            'bio' => 'nullable|string|max:500',
            'headline' => 'nullable|string|max:150',
            'institution' => 'nullable|string|max:150',
            'location' => 'nullable|string|max:150',
               'website' => 'nullable|url|max:255',
               'city' => 'nullable|string|max:100',
            'ig' => 'nullable|url',
            'avatar' => 'nullable|image|max:2048',
            'cover_image' => 'nullable|image|max:4096',
        ]);

        if ($request->hasFile('avatar')) {
            $data['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }
        if ($request->hasFile('cover_image')) {
            $data['cover_image'] = $request->file('cover_image')->store('covers', 'public');
        }

        // derive display name from first/last name when provided
        if (!empty($data['first_name']) || !empty($data['last_name'])) {
            $data['name'] = trim(($data['first_name'] ?? $user->first_name).' '.($data['last_name'] ?? $user->last_name));
        }

        $user->update($data);

        return back()->with('success', 'Profile updated.');
    }

    public function storeArtwork(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:150',
            'description' => 'nullable|string',
            'category_id' => 'nullable|exists:categories,id',
            'image' => 'required|image|max:10240',
        ]);

        $path = $request->file('image')->store('artworks', 'public');

        $art = Artwork::create([
            'user_id' => Auth::id(),
            'category_id' => $request->input('category_id'),
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'image_path' => $path,
        ]);

        return back()->with('success', 'Artwork uploaded.');
    }

    public function destroyArtwork(\Illuminate\Http\Request $request, Artwork $art)
    {
        $user = Auth::user();
        if (!$user || $user->id !== $art->user_id) {
            abort(403);
        }

        // remove image file if present
        if ($art->image_path && \Illuminate\Support\Facades\Storage::disk('public')->exists($art->image_path)) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($art->image_path);
        }

        $art->delete();

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['success' => true]);
        }

        return back()->with('success', 'Artwork deleted.');
    }

    public function follow($username)
    {
        $target = User::where('username', $username)->firstOrFail();
        $me = Auth::user();

        if ($me->id === $target->id) {
            return back();
        }

        $me->following()->syncWithoutDetaching([$target->id]);
        return back()->with('success', 'You are now following '.$target->username);
    }

    public function unfollow($username)
    {
        $target = User::where('username', $username)->firstOrFail();
        $me = Auth::user();
        $me->following()->detach($target->id);
        return back()->with('success', 'Unfollowed '.$target->username);
    }
}
