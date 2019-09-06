<?php
declare(strict_types=1);


namespace Tests;


use InteropApp\Infrastructure\Markdown\Parser;
use InteropApp\Infrastructure\Persistence\MarkdownPostsInFiles;
use PHPUnit\Framework\TestCase;

class TestApp extends TestCase
{
    protected function getPosts(): MarkdownPostsInFiles
    {
        $path = projectRoot() . '/tests/stub';
        $parser = new Parser();
        return new MarkdownPostsInFiles($path, $parser);
    }
}