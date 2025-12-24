<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ExploreController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;

Route::get('/', [ExploreController::class, 'index']);
Route::get('/explore', [ExploreController::class, 'index']);
Route::get('/dashboard', [ExploreController::class, 'dashboard'])->name('dashboard');
Route::get('/api/explore/load-more', [ExploreController::class, 'loadMore']);
Route::get('/search', [SearchController::class, 'search']);
Route::get('/category/{category}', [SearchController::class, 'category'])->name('category');

Route::get('/about', function () {
    return view('about');
});

Route::get('/community', function () {
    return view('community');
});

Route::get('/ilustrasi', function () {
    return view('ilustrasi');
});

Route::get('/branding', function () {
    return view('branding');
});

Route::get('/nirmana', function () {
    return view('nirmana');
});

Route::get('/semua-kategori', function () {
    return view('semua-kategori');
});

// Auth Routes
Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'store']);
Route::get('/register', [RegisterController::class, 'index'])->name('register');
Route::post('/register', [RegisterController::class, 'store']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Profile routes
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UploadController;
use App\Http\Controllers\CommunityController;

Route::get('/users/{identifier}', [ProfileController::class, 'show'])->name('profile.show');
Route::middleware('auth')->group(function () {
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/artworks', [ProfileController::class, 'storeArtwork'])->name('profile.artworks.store');
    Route::delete('/profile/artworks/{art}', [ProfileController::class, 'destroyArtwork'])->name('profile.artworks.destroy');
    Route::post('/upload/artwork', [UploadController::class, 'storeArtwork'])->name('upload.artwork');
    Route::post('/upload/article', [UploadController::class, 'storeArticle'])->name('upload.article');

    // Artwork interactions
    Route::post('/artworks/{art}/like', [App\Http\Controllers\ArtworkController::class, 'toggleLike'])->name('artworks.like')->middleware('auth');
    Route::post('/artworks/{art}/save', [App\Http\Controllers\ArtworkController::class, 'toggleSave'])->name('artworks.save')->middleware('auth');

    Route::post('/users/{username}/follow', [ProfileController::class, 'follow'])->name('profile.follow');
    Route::post('/users/{username}/unfollow', [ProfileController::class, 'unfollow'])->name('profile.unfollow');

    // Article deletion (only for authenticated creators)
    Route::delete('/articles/{article}', [App\Http\Controllers\ArticleController::class, 'destroy'])->name('articles.destroy');
});

// Community listing (articles)
Route::get('/community', [CommunityController::class, 'index'])->name('community.index');

// Public share endpoint for artworks (record share counts)
Route::post('/artworks/{art}/share', [App\Http\Controllers\ArtworkController::class, 'recordShare'])->name('artworks.share');

// debug notify page (convenience for local testing, harmless in other envs)
require_once base_path('routes/web_debug_notify.php');
// debug sample creation endpoint (local testing)
require_once base_path('routes/web_debug_samples.php');
// Article show route
use App\Http\Controllers\ArticleController;
Route::get('/articles/{article}', [ArticleController::class, 'show'])->name('articles.show');

// Temporary dev-only route to seed sample artworks (only in local env)
Route::get('/dev/seed-sample', function () {
    if (!app()->environment('local')) {
        abort(404);
    }

    $user = \App\Models\User::firstOrCreate(
        ['email' => 'sample@local.test'],
        ['name' => 'Sample Creator', 'username' => 'samplecreator', 'password' => bcrypt('password')]
    );

    // ensure storage folder
    if (!\Illuminate\Support\Facades\Storage::disk('public')->exists('artworks')) {
        \Illuminate\Support\Facades\Storage::disk('public')->makeDirectory('artworks');
    }

    $svg = '<svg xmlns="http://www.w3.org/2000/svg" width="800" height="800" viewBox="0 0 800 800"><rect width="100%" height="100%" fill="#f6f6f6"/><g fill="#ddd"><rect x="40" y="40" width="200" height="200" rx="6"/><rect x="260" y="40" width="200" height="200" rx="6"/><rect x="40" y="260" width="420" height="420" rx="6"/></g><text x="50%" y="50%" dominant-baseline="middle" text-anchor="middle" fill="#999" font-size="28">Artwork Placeholder</text></svg>';

    \Illuminate\Support\Facades\Storage::disk('public')->put('artworks/sample.svg', $svg);

    \App\Models\Artwork::firstOrCreate([
        'user_id' => $user->id,
        'title' => 'Sketsa 2',
        'description' => 'Deskripsi karya contoh (poster, teknik, dll).',
        'image_path' => 'artworks/sample.svg',
    ]);

    return 'Sample artworks seeded';
});

// Dev route to backfill missing usernames for existing users
Route::get('/dev/backfill-usernames', function () {
    if (!app()->environment('local')) abort(404);
    $users = \App\Models\User::whereNull('username')->orWhere('username', '')->get();
    foreach ($users as $user) {
        $base = Illuminate\Support\Str::slug($user->name ?: $user->email ?: 'user');
        $candidate = $base;
        $i = 0;
        while (\App\Models\User::where('username', $candidate)->exists()) {
            $i++;
            $candidate = $base . '-' . $i;
        }
        $user->username = $candidate;
        $user->save();
    }
    return 'Backfilled '.count($users).' users';
});

// Debug CSRF route (dev only) — returns server-side tokens so you can compare with browser
Route::get('/__debug/csrf', function (\Illuminate\Http\Request $request) {
    if (!app()->environment('local')) abort(404);
    $meta = csrf_token();
    $cookie = $request->cookie('XSRF-TOKEN');
    $sessionId = $request->cookie(config('session.cookie'));
    return response()->json([ 'csrf_meta' => $meta, 'cookie_xsrf' => $cookie, 'session_cookie' => $sessionId, 'cookies' => $request->cookie() ]);
});