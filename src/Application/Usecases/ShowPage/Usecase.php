<?php
declare(strict_types=1);


namespace InteropApp\Application\Usecases\ShowPage;


use InteropApp\Domain\Post\MarkdownPosts;

final class Usecase
{
    protected const PER_PAGE = 10;

    /** @var MarkdownPosts */
    private $posts;

    public function __construct(MarkdownPosts $posts) { $this->posts = $posts; }

    public function __invoke(Request $input, Presenter $output): void
    {
        $page = $this->posts->getAllPaginated(self::PER_PAGE, $input->page);
        $output->present($page);
    }

}