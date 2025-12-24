<?php

namespace App\Http\Controllers;

use App\Models\Artwork;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;

class UploadController extends Controller
{
    public function storeArtwork(Request $request)
    {
        if (! Schema::hasTable('artworks')) {
            return back()->with('error', 'Artworks table not found. Please run database migrations.');
        }

        $data = $request->validate([
            'title' => 'required|string|max:150',
            'category_id' => 'nullable|exists:categories,id',
            'description' => 'nullable|string|max:1000',
            'image' => 'required|image|max:10240',
        ]);

        $path = $request->file('image')->store('artworks', 'public');

        Artwork::create([
            'user_id' => Auth::id(),
            'category_id' => $data['category_id'] ?? null,
            'title' => $data['title'],
            'description' => $data['description'] ?? null,
            'image_path' => $path,
        ]);

        return back()->with('success', 'Artwork uploaded.');
    }

    public function storeArticle(Request $request)
    {
        if (! Schema::hasTable('articles')) {
            return back()->with('error', 'Articles table not found. Please run database migrations.');
        }

        $data = $request->validate([
            'title' => 'required|string|max:200',
            'category_id' => 'nullable|exists:categories,id',
            'body' => 'required|string',
            'image' => 'nullable|image|max:10240',
        ]);

        $path = null;
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('articles', 'public');
        }

        Article::create([
            'user_id' => Auth::id(),
            'category_id' => $data['category_id'] ?? null,
            'title' => $data['title'],
            'body' => $data['body'],
            'image_path' => $path,
        ]);

        return back()->with('success', 'Article posted.');
    }
}
