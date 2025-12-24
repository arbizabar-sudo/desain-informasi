<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Artwork;
use Illuminate\Support\Str;

Route::match(['get','post'], '/debug/create-sample', function (Request $request) {
    if (!app()->environment('local') && !config('app.debug')) {
        return response()->json(['error' => 'Not allowed'], 403);
    }

    $ownerEmail = $request->input('owner_email', 'owner@example.test');
    $ownerPassword = $request->input('owner_password', 'password');
    $actorEmail = $request->input('actor_email', 'actor@example.test');
    $actorPassword = $request->input('actor_password', 'password');

    // create or find users
    $owner = User::firstOrCreate([
        'email' => $ownerEmail,
    ], [
        'name' => 'Owner User',
        'username' => Str::slug(Str::before($ownerEmail, '@')) . '-owner',
        'password' => bcrypt($ownerPassword),
    ]);

    $actor = User::firstOrCreate([
        'email' => $actorEmail,
    ], [
        'name' => 'Actor User',
        'username' => Str::slug(Str::before($actorEmail, '@')) . '-actor',
        'password' => bcrypt($actorPassword),
    ]);

    // create artwork for owner
    $art = Artwork::create([
        'user_id' => $owner->id,
        'title' => 'Debug Artwork ' . Str::random(6),
        'image_path' => 'images/putri.jpeg',
    ]);

    return response()->json([
        'owner' => ['id' => $owner->id, 'email' => $ownerEmail, 'password' => $ownerPassword, 'username' => $owner->username],
        'actor' => ['id' => $actor->id, 'email' => $actorEmail, 'password' => $actorPassword, 'username' => $actor->username],
        'artwork' => ['id' => $art->id, 'title' => $art->title],
    ]);
})->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class]);