<?php
declare(strict_types=1);


namespace InteropApp\Domain\Post;

interface MarkdownPosts
{
    public function readBySlug(string $slug): ?MarkdownPost;

    public function count(): int;

    public function getAllPaginated(int $perPage, int $page): Page;
}