<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Models\Artwork;
use App\Models\Article;
use Illuminate\Support\Facades\Schema;

class UploadSidebarTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_see_upload_actions()
    {
        // Ensure no user is authenticated for this test
        \Illuminate\Support\Facades\Auth::logout();

        $res = $this->get('/');
        $res->assertDontSee('Upload Karya');
        $res->assertDontSee('Upload Artikel');
    }

    public function test_authenticated_user_can_upload_artwork_via_sidebar()
    {
        Storage::fake('public');
        $user = User::factory()->create();

        $this->actingAs($user)
            ->post(route('upload.artwork'), [
                'title' => 'Sidebar Art',
                'description' => 'desc',
                'image' => UploadedFile::fake()->create('art.jpg', 800, 'image/jpeg'),
            ])
            ->assertSessionHas('success');

        $this->assertDatabaseHas('artworks', ['title' => 'Sidebar Art', 'user_id' => $user->id]);

        // Explore page should include thumbnail with data attributes for modal
        $res = $this->get('/');
        $res->assertSee('data-title="Sidebar Art"');
        $res->assertSee('data-artwork-desc="desc"');
        // Modal container and creator elements should be present
        $res->assertSee('id="modalAvatar"');
        $res->assertSee('id="modalCreatorName"');
        $res->assertSee('id="modalCreatorUsername"');
        // Authenticated user should have Karya/Artikel buttons available in DOM (hidden until upload primary clicked)
        $res->assertSee('Karya');
        $res->assertSee('Artikel');
    }

    public function test_uploaded_article_appears_in_community_listing()
    {
        Storage::fake('public');
        $user = User::factory()->create();

        $this->actingAs($user)
            ->post(route('upload.article'), [
                'title' => 'Sidebar Article',
                'body' => str_repeat('content ', 40),
                'image' => UploadedFile::fake()->create('cover.jpg', 900, 'image/jpeg'),
            ])
            ->assertSessionHas('success');

        $this->assertDatabaseHas('articles', ['title' => 'Sidebar Article', 'user_id' => $user->id]);

        $res = $this->get('/community');
        $res->assertSee('Sidebar Article');
        $res->assertSee('By');
    }

    public function test_authenticated_user_can_upload_article_via_sidebar()
    {
        Storage::fake('public');
        $user = User::factory()->create();

        $this->actingAs($user)
            ->post(route('upload.article'), [
                'title' => 'Sidebar Article',
                'body' => str_repeat('content ', 40),
                'image' => UploadedFile::fake()->create('cover.jpg', 900, 'image/jpeg'),
            ])
            ->assertSessionHas('success');

        $this->assertDatabaseHas('articles', ['title' => 'Sidebar Article', 'user_id' => $user->id]);
    }

    public function test_article_post_fails_when_articles_table_missing()
    {
        // simulate missing articles table
        Schema::dropIfExists('articles');

        Storage::fake('public');
        $user = User::factory()->create();

        $this->actingAs($user)
            ->post(route('upload.article'), [
                'title' => 'Sidebar Article',
                'body' => str_repeat('content ', 40),
                'image' => UploadedFile::fake()->create('cover.jpg', 900, 'image/jpeg'),
            ])
            ->assertSessionHas('error');
    }
}
