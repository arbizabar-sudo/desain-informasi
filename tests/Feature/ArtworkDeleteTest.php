<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Models\Artwork;

class ArtworkDeleteTest extends TestCase
{
    use RefreshDatabase;

    public function test_owner_can_delete_artwork()
    {
        Storage::fake('public');

        $user = User::factory()->create();

        // create fake file and artwork
        $path = 'artworks/test-delete.jpg';
        Storage::disk('public')->put($path, 'data');

        $art = Artwork::create([
            'user_id' => $user->id,
            'title' => 'To be deleted',
            'description' => 'desc',
            'image_path' => $path,
        ]);

        $this->actingAs($user)
            ->delete(route('profile.artworks.destroy', $art->id))
            ->assertSessionHas('success');

        $this->assertDatabaseMissing('artworks', ['id' => $art->id]);
        Storage::disk('public')->assertMissing($path);

        // also test AJAX delete returns JSON
        $art2 = Artwork::create([
            'user_id' => $user->id,
            'title' => 'To be deleted 2',
            'description' => 'desc',
            'image_path' => null,
        ]);

        $this->actingAs($user)
            ->deleteJson(route('profile.artworks.destroy', $art2->id))
            ->assertStatus(200)->assertJson(['success' => true]);

        $this->assertDatabaseMissing('artworks', ['id' => $art2->id]);
    }

    public function test_non_owner_cannot_delete_artwork()
    {
        $user = User::factory()->create();
        $other = User::factory()->create();

        $art = Artwork::create([
            'user_id' => $other->id,
            'title' => 'Protected',
            'description' => 'desc',
            'image_path' => null,
        ]);

        $this->actingAs($user)
            ->delete(route('profile.artworks.destroy', $art->id))
            ->assertStatus(403);

        $this->assertDatabaseHas('artworks', ['id' => $art->id]);
    }
}
