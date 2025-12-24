<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SearchController extends Controller
{
    /**
     * Search for artworks by title, description, or artist
     */
    public function search(Request $request)
    {
        $query = $request->get('q', '');
        $results = [];
        $pageTitle = 'Search Results';

        if (!empty($query)) {
            $results = $this->searchArtworks($query);
            $pageTitle = "Results for \"$query\"";
        }

        return view('search', [
            'query' => $query,
            'results' => $results,
            'pageTitle' => $pageTitle,
        ]);
    }

    /**
     * Display artworks by category/modal (e.g., graphic design, illustration, etc.)
     */
    public function category(Request $request, string $category)
    {
        $results = $this->getArtworksByCategory($category);
        $categoryName = $this->getCategoryName($category);

        return view('search', [
            'query' => '',
            'results' => $results,
            'pageTitle' => $categoryName,
            'category' => $category,
        ]);
    }

    /**
     * Search artworks by keyword
     */
    private function searchArtworks(string $keyword): array
    {
        $allArtworks = $this->getAllArtworks();
        $keyword = strtolower($keyword);

        // Filter artworks by keyword in title, description, or artist
        $filtered = array_filter($allArtworks, function ($artwork) use ($keyword) {
            return strpos(strtolower($artwork['title']), $keyword) !== false ||
                   strpos(strtolower($artwork['description']), $keyword) !== false ||
                   strpos(strtolower($artwork['artist']), $keyword) !== false;
        });

        return array_values($filtered);
    }

    /**
     * Get artworks by category/modal type
     */
    private function getArtworksByCategory(string $category): array
    {
        $slug = strtolower($category);

        // If artworks table exists, fetch from database
        if (\Illuminate\Support\Facades\Schema::hasTable('artworks') && \Illuminate\Support\Facades\Schema::hasTable('categories')) {
            $cat = \App\Models\Category::where('slug', $slug)->first();
            if (!$cat) return [];

            $arts = \App\Models\Artwork::with('user','category')
                ->where('category_id', $cat->id)
                ->latest()
                ->get();

            return $arts->map(function ($art) {
                return [
                    'id' => $art->id,
                    'title' => $art->title,
                    'artist' => optional($art->user)->username ?? optional($art->user)->name ?? '',
                    'description' => $art->description ?? '',
                    'image' => !empty($art->image_path) ? asset('storage/'.$art->image_path) : ($art->image ?? null),
                    'date' => isset($art->created_at) ? $art->created_at->diffForHumans() : '',
                    'size' => $art->size ?? 'normal',
                ];
            })->toArray();
        }

        // Fallback to static mapping for sample data
        $allArtworks = $this->getAllArtworks();
        $category = strtolower($category);

        // Map categories to artwork IDs or tags
        $categoryMap = [
            'graphic' => ['id' => [1, 5, 10]],
            'illustration' => ['id' => [3, 7, 11]],
            'photography' => ['id' => [2, 4, 8]],
            'typography' => ['id' => [6, 9, 12]],
            'uiux' => ['id' => [1, 7, 11]],
            'identity' => ['id' => [5, 10, 12]],
        ];

        // Get IDs for this category
        $categoryIds = $categoryMap[$category]['id'] ?? [];

        // Filter by category
        $filtered = array_filter($allArtworks, function ($artwork) use ($categoryIds) {
            return in_array($artwork['id'], $categoryIds);
        });

        return array_values($filtered);
    }

    /**
     * Get human-readable category name
     */
    private function getCategoryName(string $category): string
    {
        $names = [
            'graphic' => 'Graphic Design',
            'illustration' => 'Illustration',
            'photography' => 'Photography',
            'typography' => 'Typography',
            'uiux' => 'UI/UX Design',
            'identity' => 'Visual Identity',
        ];

        return $names[strtolower($category)] ?? ucfirst($category);
    }

    /**
     * Get all available artworks
     */
    private function getAllArtworks(): array
    {
        return [
            [
                'id' => 1,
                'title' => 'Kamar Siang Hari',
                'artist' => '@ainidewadkv',
                'description' => 'Karya ini menggambarkan suasana kamar di pagi hari dengan cahaya lembut.',
                'image' => '/images/putri.jpeg',
                'date' => 'Published Dec 10, 2025',
                'size' => 'tall',
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
    }
}
