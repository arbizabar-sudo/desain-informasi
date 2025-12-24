<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Artwork;

class ArtworkInteractionTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_like_and_save_artwork_and_appear_on_profile()
    {
        $user = User::factory()->create();
        $author = User::factory()->create();
        $art = Artwork::create(['user_id' => $author->id, 'title' => 'Test Art', 'image_path' => 'artworks/test.jpg']);

        $this->actingAs($user)->post(route('artworks.like', $art->id))->assertSessionHas('success');
        $this->assertDatabaseHas('artwork_likes', ['user_id' => $user->id, 'artwork_id' => $art->id]);

        $this->actingAs($user)->post(route('artworks.save', $art->id))->assertSessionHas('success');
        $this->assertDatabaseHas('artwork_saves', ['user_id' => $user->id, 'artwork_id' => $art->id]);

        // saved/liked appear on user's profile
        $res = $this->actingAs($user)->get(route('profile.show', $user->username));
        $res->assertSee('Saved');
        $res->assertSee('Liked');
    }

    public function test_share_increments_share_count_and_returns_json()
    {
        $author = User::factory()->create();
        $art = Artwork::create(['user_id' => $author->id, 'title' => 'Share Art', 'image_path' => 'artworks/share.jpg']);

        // CSRF middleware can block JSON POSTs in tests; disable it for this request
        $this->withoutMiddleware(\Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class);
        $res = $this->postJson(route('artworks.share', $art->id));
        $res->assertJsonStructure(['share_count']);
        $this->assertDatabaseHas('artworks', ['id' => $art->id, 'share_count' => 1]);
    }
}

