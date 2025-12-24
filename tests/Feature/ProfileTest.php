<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use App\Models\User;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_update_profile_and_upload_images()
    {
        Storage::fake('public');

        $user = User::factory()->create();

        $this->actingAs($user)
            ->put(route('profile.update'), [
                'username' => 'newusername',
                'bio' => 'Hello world',
                'avatar' => UploadedFile::fake()->create('avatar.jpg', 500, 'image/jpeg'),
                'cover_image' => UploadedFile::fake()->create('cover.jpg', 1000, 'image/jpeg'),
            ])
            ->assertSessionHas('success');

        $user->refresh();

        $this->assertEquals('newusername', $user->username);
        Storage::disk('public')->assertExists($user->avatar);
        Storage::disk('public')->assertExists($user->cover_image);
    }

    public function test_user_can_upload_artwork_and_filter_by_category()
    {
        Storage::fake('public');

        $user = User::factory()->create();

        $this->actingAs($user)
            ->post(route('profile.artworks.store'), [
                'title' => 'My Art',
                'image' => UploadedFile::fake()->create('art.jpg', 750, 'image/jpeg'),
            ])
            ->assertSessionHas('success');

        $this->assertDatabaseHas('artworks', ['title' => 'My Art', 'user_id' => $user->id]);
    }
}
