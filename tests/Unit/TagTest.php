<?php

namespace Tests\Unit;

use App\Models\Article;
use App\Models\Tag;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TagTest extends TestCase
{
    use RefreshDatabase;
    /**
     * Test that a Tag can be created and has a name.
     */
    public function test_a_tag_can_be_created()
    {
        $tag = Tag::factory()->create(['name' => 'Test Tag']);

        $this->assertDatabaseHas('tags', [
            'name' => 'Test Tag',
        ]);

        $this->assertEquals('Test Tag', $tag->name);
    }

    /**
     * Test that a Tag can be associated with Articles.
     */
    public function test_a_tag_can_have_many_articles()
    {
        $tag = Tag::factory()->create(['name' => 'Coding']);

        $article1 = Article::factory()->create(['title' => 'Laravel Tips']);
        $article2 = Article::factory()->create(['title' => 'PHP Best Practices']);

        $tag->articles()->attach($article1->id);
        $tag->articles()->attach($article2->id);

        $tag->refresh();

        $this->assertCount(2, $tag->articles);

        $this->assertTrue($tag->articles->contains($article1));
        $this->assertTrue($tag->articles->contains($article2));
    }

    /**
     * Test that an Article can have many Tags.
     */
    public function test_an_article_can_have_many_tags()
    {
        $article = Article::factory()->create(['title' => 'My Awesome Article']);

        $tag1 = Tag::factory()->create(['name' => 'Health']);
        $tag2 = Tag::factory()->create(['name' => 'Fitness']);

        $article->tags()->attach($tag1->id);
        $article->tags()->attach($tag2->id);

        $article->refresh();

        $this->assertCount(2, $article->tags);

        $this->assertTrue($article->tags->contains($tag1));
        $this->assertTrue($article->tags->contains($tag2));
    }

    /**
     * Test that a tag's articles relationship returns a collection.
     */
    public function test_tag_articles_relationship_returns_collection()
    {
        $tag = Tag::factory()->create();
        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Collection::class, $tag->articles);
    }

    /**
     * Test that an article's tags relationship returns a collection.
     */
    public function test_article_tags_relationship_returns_collection()
    {
        $article = Article::factory()->create();
        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Collection::class, $article->tags);
    }
}
