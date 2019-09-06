<?php
declare(strict_types=1);


namespace InteropApp\Domain\Post;


use Webmozart\Assert\Assert;

final class Page
{
    /** @var int */
    private $pages;
    /** @var int */
    private $page;
    /** @var MarkdownPost[] */
    private $posts;

    /**
     * @param int $pages
     * @param int $page
     * @param MarkdownPost[] $posts
     */
    public function __construct(int $pages, int $page, array $posts)
    {
        Assert::greaterThanEq($pages, 0);
        Assert::greaterThanEq($page, 1);
        Assert::allIsInstanceOf($posts, MarkdownPost::class);

        $this->pages = $pages;
        $this->page = $page;
        $this->posts = $posts;
    }


    /**
     * @return int
     */
    public function pages(): int
    {
        return $this->pages;
    }

    /**
     * @return int
     */
    public function page(): int
    {
        return $this->page;
    }

    public function isLast(): bool
    {
        return $this->pages === $this->page;
    }

    public function isFirst(): bool
    {
        return $this->page === 1;
    }

    /**
     * @return MarkdownPost[]
     */
    public function posts(): array
    {
        return $this->posts;
    }
}