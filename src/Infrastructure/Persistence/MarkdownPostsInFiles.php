<?php
declare(strict_types=1);


namespace InteropApp\Infrastructure\Persistence;


use InteropApp\Domain\Post\MarkdownPost;
use InteropApp\Domain\Post\MarkdownPosts;
use InteropApp\Domain\Post\Page;
use InteropApp\Infrastructure\Markdown\Parser;

class MarkdownPostsInFiles implements MarkdownPosts
{
    /** @var string */
    private $path;
    /** @var Parser */
    private $parser;

    public function __construct(string $path, Parser $parser)
    {
        $this->path = $path;
        $this->parser = $parser;
    }


    public function readBySlug(string $slug): ?MarkdownPost
    {
        foreach ($this->getFilesIterator() as $filePath) {

            $text = file_get_contents($filePath);
            $meta = $this->parser->parseMeta($text);

            if ($meta->slug() === $slug) {
                return new MarkdownPost($this->parser->parseBody($text), $meta);
            }
        }

        return null;
    }

    public function count(): int
    {
        return iterator_count($this->getFilesIterator());
    }

    /**
     * Pages starts from 1
     */
    public function getAllPaginated(int $perPage, int $page): Page
    {
        $posts = [];
        $totalFiles = 0;
        $skipFirst = $perPage * ($page - 1);
        foreach ($this->getFilesIterator() as $filePath) {
            $totalFiles++;

            if ($skipFirst-- > 0) {
                continue;
            }

            if (count($posts) === $perPage) {
                continue;
            }
            $text = file_get_contents($filePath);
            $posts[] = new MarkdownPost($this->parser->parseBody($text), $this->parser->parseMeta($text));
        }

        return new Page(
            (int)ceil($totalFiles / $perPage),
            $page,
            $posts
        );
    }

    private function getFilesIterator(): \Traversable
    {
        $f = function () {
            foreach (glob($this->path . '/*.md') as $filePath) {
                if (!is_readable($filePath)) {
                    throw new \RuntimeException(sprintf('file %s is not readable', $filePath));
                }
                yield $filePath;
            }
        };

        return $f();
    }


}