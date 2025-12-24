<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function show(Article $article)
    {
        $article->loadMissing('user','category');
        return view('articles.show', compact('article'));
    }

    public function destroy(\Illuminate\Http\Request $request, Article $article)
    {
        $user = auth()->user();
        if (!$user || $user->id !== $article->user_id) {
            abort(403);
        }

        // delete associated image from storage if present
        if ($article->image_path) {
            try { \Illuminate\Support\Facades\Storage::disk('public')->delete($article->image_path); } catch (\Exception $e) { /* ignore cleanup errors */ }
        }

        $article->delete();

        // If request expects JSON (AJAX), return JSON so client can stay on the same page
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['success' => true]);
        }

        // fallback: redirect back
        return redirect()->back()->with('status', 'Artikel berhasil dihapus.');
    }
} 
