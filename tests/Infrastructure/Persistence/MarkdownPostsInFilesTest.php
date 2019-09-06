<?php
declare(strict_types=1);

namespace Tests\Infrastructure\Persistence;

use Tests\TestApp;

class MarkdownPostsInFilesTest extends TestApp
{

    public function testItFindsPostBySlug(): void
    {
        $posts = $this->getPosts();
        $slug = 'sample-post';
        $post = $posts->readBySlug($slug);
        $expectedText = <<<MD
# New blog post
blabla 
blabla
MD;

        $this->assertNotNull($post);
        $this->assertEquals($expectedText, $post->getBody());
        $this->assertEquals($slug, $post->meta()->slug());
    }

    public function testItReturnsNullIfNotFound(): void
    {
        $posts = $this->getPosts();
        $post = $posts->readBySlug('unexpected-slug');
        $this->assertNull($post);
    }

    public function testItReturnsAllPostsCount(): void
    {
        $posts = $this->getPosts();
        $this->assertEquals(3, $posts->count());
    }

    public function testItReturnsAllPostsForFirstPage(): void
    {
        $posts = $this->getPosts();
        $page = $posts->getAllPaginated(2, 1);
        $this->assertEquals(1, $page->page());
        $this->assertEquals(2, $page->pages());
        $this->assertCount(2, $page->posts());
    }

    public function testItReturnsAllPostsForLastPage(): void
    {
        $posts = $this->getPosts();
        $page = $posts->getAllPaginated(2, 2);
        $this->assertEquals(2, $page->page());
        $this->assertEquals(2, $page->pages());
        $this->assertCount(1, $page->posts());
    }
}
