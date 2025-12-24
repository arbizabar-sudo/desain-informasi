<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Artwork;
use Illuminate\Support\Facades\Auth;

class ArtworkController extends Controller
{
    public function toggleLike(Artwork $art)
    {
        $user = Auth::user();
        if (!$user) abort(403);

        $liked = false;
        if ($user->likedArtworks()->wherePivot('artwork_id', $art->id)->exists()) {
            $user->likedArtworks()->detach($art->id);
            $liked = false;
        } else {
            $user->likedArtworks()->attach($art->id);
            $liked = true;
        }

        // refresh counts
        $likeCount = $art->likedBy()->count();

        if (request()->wantsJson()) {
            return response()->json(['liked' => $liked, 'like_count' => $likeCount]);
        }

        return back()->with('success', $liked ? 'Liked' : 'Unliked');
    }

    public function toggleSave(Artwork $art)
    {
        $user = Auth::user();
        if (!$user) abort(403);

        $saved = false;
        if ($user->savedArtworks()->wherePivot('artwork_id', $art->id)->exists()) {
            $user->savedArtworks()->detach($art->id);
            $saved = false;
        } else {
            $user->savedArtworks()->attach($art->id);
            $saved = true;
        }

        $saveCount = $art->savedBy()->count();

        if (request()->wantsJson()) {
            return response()->json(['saved' => $saved, 'save_count' => $saveCount]);
        }

        return back()->with('success', $saved ? 'Saved' : 'Removed from saved');
    }

    public function recordShare(Artwork $art)
    {
        // increment share count; sharing can be recorded without auth
        $art->increment('share_count');
        $art->refresh();

        // always return JSON for JS callers
        return response()->json(['share_count' => $art->share_count]);
    }
}
