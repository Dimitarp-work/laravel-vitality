<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Article;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ArticlePageTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that the articles page loads and displays articles in descending order.
     * This covers:
     * - Page loads successfully (200 status)
     * - Articles are displayed in descending order by date (Newest is first)
     */
    public function test_articles_page_loads_and_displays_articles_in_descending_order()
    {
        $user = User::factory()->create();

        $tag1 = Tag::factory()->create(['name' => 'Wellness']);
        $tag2 = Tag::factory()->create(['name' => 'Fitness']);

        $olderArticle = Article::factory()->create([
            'title' => 'Older Article',
            'created_at' => now()->subDays(5),
        ]);
        $olderArticle->tags()->attach($tag1->id);

        $newerArticle = Article::factory()->create([
            'title' => 'Newer Article',
            'created_at' => now(),
        ]);
        $newerArticle->tags()->attach($tag2->id);

        $response = $this->actingAs($user)->get(route('articles.index'));

        $response->assertStatus(200);

        $response->assertSeeTextInOrder([
            'Newer Article',
            'Older Article'
        ]);
    }

    /**
     * Test that the articles section is empty when no articles are available.
     * This covers:
     * - If articles are unavailable, the section is empty (displays "No articles found.")
     * - Page still loads successfully (200 status) even with no articles.
     */
    public function test_articles_section_is_empty_when_no_articles_are_available()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('articles.index'));

        $response->assertStatus(200);

        $response->assertDontSeeText('Newer Article');
        $response->assertDontSeeText('Older Article');
        $response->assertDontSeeText('Article Title');

        $response->assertSeeText('No articles found.');
    }
}
