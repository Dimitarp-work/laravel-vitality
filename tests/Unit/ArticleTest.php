<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Article;
use App\Models\Tag;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class ArticleTest extends TestCase
{
    use RefreshDatabase; // Use RefreshDatabase trait to reset the database for each test

    /**
     * Test that an Article can be instantiated and has fillable attributes.
     */
    public function test_article_can_be_created_and_has_fillable_attributes()
    {
        $articleData = [
            'title' => 'Test Article Title',
            // FIX: Add the 'content' field as it's required by your database
            'content' => 'This is the content of the test article.', // <--- ADD THIS LINE
            'views' => 0,
        ];

        $article = Article::create($articleData);

        $this->assertNotNull($article);
        $this->assertInstanceOf(Article::class, $article);
        $this->assertEquals($articleData['title'], $article->title);
        // FIX: Assert the 'content' field
        $this->assertEquals($articleData['content'], $article->content); // <--- CHANGE FROM $articleData['body'] to $articleData['content']
        $this->assertEquals($articleData['views'], $article->views);
    }

    /**
     * Test the 'tags' relationship of an Article.
     */
    public function test_article_can_have_many_tags()
    {
        $article = Article::factory()->create();
        $tag1 = Tag::factory()->create();
        $tag2 = Tag::factory()->create();

        $article->tags()->attach([$tag1->id, $tag2->id]);

        $this->assertInstanceOf(BelongsToMany::class, $article->tags());
        $this->assertCount(2, $article->tags);
        $this->assertTrue($article->tags->contains($tag1));
        $this->assertTrue($article->tags->contains($tag2));
    }

    /**
     * Test that an article's views can be incremented.
     */
    public function test_article_views_can_be_incremented()
    {
        $article = Article::factory()->create(['views' => 0]);

        $this->assertEquals(0, $article->views);

        $article->increment('views'); // Laravel's built-in increment method
        $article->refresh(); // Refresh the model to get the updated 'views' from the database

        $this->assertEquals(1, $article->views);

        $article->increment('views', 5); // Increment by more than 1
        $article->refresh();
        $this->assertEquals(6, $article->views);
    }
}
