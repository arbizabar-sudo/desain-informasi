<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ExploreController extends Controller
{
    /**
     * Display the explore page with portfolio items
     */
    public function index()
    {
        // Fetch artworks from database with pagination when table exists
        $artworks = [];
        $categories = collect();
        if (\Illuminate\Support\Facades\Schema::hasTable('artworks')) {
            $artworks = \App\Models\Artwork::with('user','category')->latest()->paginate(12);
        } else {
            // Fallback sample items to keep views working when DB not migrated (eg tests)
            $artworks = collect($this->getPortfolioItems(1))->map(function ($it) {
                // ensure nested user is an object so view can access ->username / ->name
                $it['user'] = (object) ($it['user'] ?? []);
                return (object) $it;
            });
        }

        if (\Illuminate\Support\Facades\Schema::hasTable('categories')) {
            $categories = \App\Models\Category::all();
        }

        return view('explore', [
            'artworks' => $artworks,
            'categories' => $categories,
        ]);
    }

    /**
     * Display the dashboard page (same content as explore but without hero)
     */
    public function dashboard()
    {
        // Fetch artworks from database with pagination when table exists
        $artworks = [];
        $categories = collect();
        if (\Illuminate\Support\Facades\Schema::hasTable('artworks')) {
            $artworks = \App\Models\Artwork::with('user','category')->latest()->paginate(12);
        } else {
            // Fallback sample items to keep views working when DB not migrated (eg tests)
            $artworks = collect($this->getPortfolioItems(1))->map(function ($it) {
                // ensure nested user is an object so view can access ->username / ->name
                $it['user'] = (object) ($it['user'] ?? []);
                return (object) $it;
            });
        }

        if (\Illuminate\Support\Facades\Schema::hasTable('categories')) {
            $categories = \App\Models\Category::all();
        }

        // Determine online users: those with last_activity within the last 2 minutes
        $onlineUsers = collect();
        if (\Illuminate\Support\Facades\Schema::hasTable('users') && \Illuminate\Support\Facades\Schema::hasColumn('users', 'last_activity')) {
            $threshold = time() - 120; // 2 minutes
            $onlineUsers = \App\Models\User::where('last_activity', '>=', $threshold)
                ->orderBy('last_activity', 'desc')
                ->limit(12)
                ->get();
        }

        return view('explore', [
            'artworks' => $artworks,
            'categories' => $categories,
            'showHero' => false,
            'onlineUsers' => $onlineUsers,
        ]);
    }

    /**
     * Load more portfolio items via AJAX for infinite scroll
     */
    public function loadMore(Request $request)
    {
        $page = $request->get('page', 1);
        
        // Fetch real artworks from database if available
        $artworks = [];
        if (\Illuminate\Support\Facades\Schema::hasTable('artworks')) {
            $artworks = \App\Models\Artwork::with('user','category')
                ->latest()
                ->paginate(12, ['*'], 'page', $page)
                ->items();
        } else {
            // Fallback to sample data
            $items = $this->getPortfolioItems(page: (int)$page);
            return response()->json([
                'success' => true,
                'items' => $items,
                'page' => $page,
            ]);
        }
        
        // Transform artworks to the expected format with counts
        $items = array_map(function ($art) {
            return [
                'id' => $art->id,
                'title' => $art->title,
                'artist' => optional($art->user)->username ?? optional($art->user)->name ?? '',
                'description' => $art->description,
                'image' => !empty($art->image_path) ? asset('storage/'.$art->image_path) : null,
                'date' => isset($art->created_at) ? $art->created_at->diffForHumans() : '',
                'size' => $art->size ?? 'normal',
                'user' => [
                    'username' => optional($art->user)->username,
                    'name' => optional($art->user)->name,
                    'avatar' => optional($art->user)->avatar_url ?? '/images/icon/profil.png',
                    'role' => optional($art->user)->role ?? '',
                ],
                'like_count' => $art->likedBy()->count(),
                'save_count' => $art->savedBy()->count(),
                'share_count' => $art->share_count ?? 0,
            ];
        }, $artworks);

        return response()->json([
            'success' => true,
            'items' => $items,
            'page' => $page,
        ]);
    }

    /**
     * Get portfolio items (paginated)
     * In a real app, this would fetch from database
     */
    private function getPortfolioItems(int $page = 1): array
    {
        $perPage = 6;
        $offset = ($page - 1) * $perPage;

        // Sample artwork data - replace with database query
        $allArtworks = [
            [
                'id' => 1,
                'title' => 'Kamar Siang Hari',
                'artist' => '@ainidewadkv',
                'description' => 'Karya ini menggambarkan suasana kamar di pagi hari dengan cahaya lembut.',
                'image' => '/images/putri.jpeg',
                'date' => 'Published Dec 10, 2025',
                'size' => 'tall', // tall or normal
            ],
            [
                'id' => 2,
                'title' => 'Senja di Kota',
                'artist' => 'Deni',
                'description' => 'Pemandangan senja yang indah di tengah kota yang ramai.',
                'image' => '/images/DENI (1).jpg',
                'date' => 'Published Dec 11, 2025',
                'size' => 'normal',
            ],
            [
                'id' => 3,
                'title' => 'Potret Alam',
                'artist' => 'Deni',
                'description' => 'Keindahan alam yang terpancar melalui setiap detail.',
                'image' => '/images/DENI (2).jpg',
                'date' => 'Published Dec 12, 2025',
                'size' => 'normal',
            ],
            [
                'id' => 4,
                'title' => 'Ekspresi Wajah',
                'artist' => 'Deni',
                'description' => 'Menangkap emosi dan ekspresi dalam setiap karya.',
                'image' => '/images/DENI (3).jpg',
                'date' => 'Published Dec 13, 2025',
                'size' => 'tall',
            ],
            [
                'id' => 5,
                'title' => 'Abstrak Warna',
                'artist' => 'Deni',
                'description' => 'Eksplorasi warna dan bentuk dalam harmoni sempurna.',
                'image' => '/images/DENI (4).jpg',
                'date' => 'Published Dec 14, 2025',
                'size' => 'normal',
            ],
            [
                'id' => 6,
                'title' => 'Interior Artistik',
                'artist' => 'Unsplash Artist',
                'description' => 'Desain interior yang mencerminkan keindahan dan fungsionalitas.',
                'image' => 'https://images.unsplash.com/photo-1460661419201-fd4cecdf8a8b?w=400&h=800&fit=crop',
                'date' => 'Published Dec 15, 2025',
                'size' => 'tall',
            ],
            [
                'id' => 7,
                'title' => 'Karakter Fantasi',
                'artist' => 'Unsplash Artist',
                'description' => 'Karakter unik yang lahir dari imajinasi kreatif.',
                'image' => 'https://images.unsplash.com/photo-1533158326339-7f3cf2404354?w=400&h=400&fit=crop',
                'date' => 'Published Dec 16, 2025',
                'size' => 'normal',
            ],
            [
                'id' => 8,
                'title' => 'Lautan Biru',
                'artist' => 'Unsplash Artist',
                'description' => 'Kedalaman samudra yang misterius dan menawan.',
                'image' => 'https://images.unsplash.com/photo-1596548438137-d51ea5c83ca5?w=400&h=400&fit=crop',
                'date' => 'Published Dec 17, 2025',
                'size' => 'normal',
            ],
            [
                'id' => 9,
                'title' => 'Musim Gugur',
                'artist' => 'Unsplash Artist',
                'description' => 'Keindahan musim gugur dalam setiap warna yang hangat.',
                'image' => 'https://images.unsplash.com/photo-1513364776144-60967b0f800f?w=400&h=400&fit=crop',
                'date' => 'Published Dec 18, 2025',
                'size' => 'normal',
            ],
            [
                'id' => 10,
                'title' => 'Kreativitas Tanpa Batas',
                'artist' => 'Artist 1',
                'description' => 'Mengeksplorasi batas-batas kreativitas tanpa hambatan.',
                'image' => 'https://images.unsplash.com/photo-1561070791-2526d30994b5?w=400&h=400&fit=crop',
                'date' => 'Published Dec 19, 2025',
                'size' => 'normal',
            ],
            [
                'id' => 11,
                'title' => 'Karya Modern',
                'artist' => 'Artist 2',
                'description' => 'Sentuhan modern dalam setiap garis dan warna.',
                'image' => 'https://images.unsplash.com/photo-1460661419201-fd4cecdf8a8b?w=400&h=400&fit=crop',
                'date' => 'Published Dec 20, 2025',
                'size' => 'normal',
            ],
            [
                'id' => 12,
                'title' => 'Desain Inovatif',
                'artist' => 'Artist 3',
                'description' => 'Inovasi desain yang menghadirkan perspektif baru.',
                'image' => 'https://images.unsplash.com/photo-1533158326339-7f3cf2404354?w=400&h=400&fit=crop',
                'date' => 'Published Dec 21, 2025',
                'size' => 'normal',
            ],
        ];

        // Slice items for pagination
        $items = array_slice($allArtworks, $offset, $perPage);

        // Ensure each fallback item has a `user` object so views can safely access ->user
        foreach ($items as $i => $it) {
            if (!isset($items[$i]['user'])) {
                $items[$i]['user'] = [
                    'username' => $it['artist'] ?? null,
                    'name' => $it['artist'] ?? null,
                ];
            }
        }

        return $items;
    }
}
