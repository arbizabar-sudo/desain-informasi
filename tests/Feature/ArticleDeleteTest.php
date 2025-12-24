<?php

namespace Tests\Feature;

use App\Models\Article;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ArticleDeleteTest extends TestCase
{
    use RefreshDatabase;

    public function test_creator_can_delete_article_via_ajax()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $article = Article::factory()->create(['user_id' => $user->id]);

        $res = $this->deleteJson(route('articles.destroy', $article->id));
        $res->assertStatus(200)->assertJson(['success' => true]);
        $this->assertDatabaseMissing('articles', ['id' => $article->id]);
    }

    public function test_non_creator_cannot_delete_article_via_ajax()
    {
        $owner = User::factory()->create();
        $other = User::factory()->create();

        $article = Article::factory()->create(['user_id' => $owner->id]);

        $this->actingAs($other);
        $res = $this->deleteJson(route('articles.destroy', $article->id));
        $res->assertStatus(403);
        $this->assertDatabaseHas('articles', ['id' => $article->id]);
    }
}
