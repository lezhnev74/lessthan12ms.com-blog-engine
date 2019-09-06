<?php
declare(strict_types=1);

namespace Tests\Infrastructure\IO\HTTP\Presenters\Homepage;

use InteropApp\Domain\Post\MarkdownPost;
use InteropApp\Domain\Post\Page;
use InteropApp\Infrastructure\Markdown\Parser;
use InteropApp\Infrastructure\UI\HTTP\Presenters\Homepage\Presenter;
use InteropApp\Infrastructure\UI\HTTP\UrlFactory;
use PHPUnit\Framework\TestCase;

class PresenterTest extends TestCase
{

    public function testItGeneratesProperViewModel(): void
    {
        $posts = $this->makePosts();
        $page = new Page(10, 2, $posts);
        $presenter = new Presenter(new UrlFactory('https://localhost'));
        $presenter->present($page);
        $viewModel = $presenter->viewModel();

        $this->assertCount(10, $viewModel->pages);
        foreach ($viewModel->pages as $i => $page) {
            $this->assertEquals($i + 1, $page->number);
            $this->assertEquals($page->number === 2, $page->isCurrent);
            $this->assertNotFalse(filter_var($page->url, FILTER_VALIDATE_URL));
        }

        $this->assertCount(2, $viewModel->posts);

        $this->assertEquals('Middle-earth in popular culture', $viewModel->posts[0]->title);
        $this->assertEquals('Friday, 06 Sep 2019', $viewModel->posts[0]->date);
        $this->assertNotFalse(filter_var($viewModel->posts[0]->url, FILTER_VALIDATE_URL));

        $this->assertEquals('Domain-driven design', $viewModel->posts[1]->title);
        $this->assertEquals('Thursday, 05 Sep 2019', $viewModel->posts[1]->date);
        $this->assertNotFalse(filter_var($viewModel->posts[1]->url, FILTER_VALIDATE_URL));
    }

    private function makePosts(): array
    {
        $posts = [];

        $postText1 = <<<TEXT
slug: middleearth-popular-culture
publish: 06.09.2019 14:00

# Middle-earth in popular culture
Middle-earth has had a profound and wide-ranging impact on popular culture. This is especially true for The Lord of the Rings, 
ever since its publication in the 1950s, but especially throughout the 1960s and 1970s, where young people embraced it as 
a countercultural saga, and its influence has been vastly extended in the present day, thanks to the live-action film trilogy 
by Peter Jackson. Many of the following references are directly inspired by the latter films rather than the book.
TEXT;
        $posts[] = new MarkdownPost($postText1, (new Parser())->parseMeta($postText1));

        $postText2 = <<<TEXT
slug: domain-driven-design
publish: 05.09.2019 15:00

# Domain-driven design
Domain-driven design is predicated on the following goals:
- placing the project's primary focus on the core domain and domain logic;
- basing complex designs on a model of the domain;
- initiating a creative collaboration between technical and domain experts to iteratively refine a conceptual model that addresses particular domain problems.
TEXT;
        $posts[] = new MarkdownPost($postText2, (new Parser())->parseMeta($postText2));

        return $posts;
    }
}
