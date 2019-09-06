<?php
declare(strict_types=1);

namespace Tests\Application\Usecases\ShowPage;

use InteropApp\Application\Usecases\ShowPage\Request;
use InteropApp\Application\Usecases\ShowPage\Presenter;
use InteropApp\Application\Usecases\ShowPage\Usecase;
use InteropApp\Domain\Post\MarkdownPosts;
use InteropApp\Domain\Post\Page;
use PHPUnit\Framework\TestCase;
use Tests\TestApp;

class UsecaseTest extends TestApp
{
    public function testItReadsAPage(): void
    {
        $usecase = new Usecase($this->getPosts());

        $input = new Request();
        $input->page = 1;
        $output = $this->makeOutput();

        $usecase($input, $output);

        $this->assertEquals($input->page, $output->page->page());
    }

    private function makeOutput(): Presenter
    {
        return new class implements Presenter
        {
            /** @var Page */
            public $page;

            public function present(Page $page): void
            {
                $this->page = $page;
            }
        };
    }
}
