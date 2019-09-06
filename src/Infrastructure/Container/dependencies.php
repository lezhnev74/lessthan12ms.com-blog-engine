<?php
declare(strict_types=1);

use InteropApp\Domain\Post\MarkdownPosts;
use InteropApp\Infrastructure\Markdown\Parser;
use InteropApp\Infrastructure\Persistence\MarkdownPostsInFiles;
use Psr\Container\ContainerInterface;

return [
    MarkdownPosts::class => function (ContainerInterface $c) {
        $path = projectRoot() . '/web_root';
        return new MarkdownPostsInFiles($path, new Parser());
    }
];