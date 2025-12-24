<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Pagination\LengthAwarePaginator;

class CommunityController extends Controller
{
    public function index(Request $request)
    {
        $category = $request->get('category');

        if (Schema::hasTable('articles')) {
            $articles = Article::with('user','category')
                ->when($category, fn($q) => $q->whereHas('category', fn($q2) => $q2->where('slug', $category)))
                ->latest()->paginate(10);
        } else {
            // Return an empty paginator so views that call ->links() still work
            $articles = new LengthAwarePaginator([], 0, 10, 1, [
                'path' => $request->url(),
                'query' => $request->query(),
            ]);
        }

        $categories = Schema::hasTable('categories') ? Category::all() : collect();

        return view('community', compact('articles','categories'));
    }
}
