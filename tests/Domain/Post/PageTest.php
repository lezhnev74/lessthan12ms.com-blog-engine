<?php
declare(strict_types=1);

namespace Tests\Domain\Post;

use InteropApp\Domain\Post\Page;
use PHPUnit\Framework\TestCase;

class PageTest extends TestCase
{
    public function testItCalculatesFirstPageCorrectly(): void
    {
        $page = new Page(10, 1, []);
        $this->assertTrue($page->isFirst());
        $this->assertFalse($page->isLast());
    }

    public function testItCalculatesLastPageCorrectly(): void
    {
        $page = new Page(2, 2, []);
        $this->assertFalse($page->isFirst());
        $this->assertTrue($page->isLast());
    }

    public function testItCalculatesLastFirstPageCorrectlyInTheMiddle(): void
    {
        $page = new Page(3, 2, []);
        $this->assertFalse($page->isFirst());
        $this->assertFalse($page->isLast());
    }

    public function testItCalculatesLastFirstPageCorrectlyForOnePage(): void
    {
        $page = new Page(1, 1, []);
        $this->assertTrue($page->isFirst());
        $this->assertTrue($page->isLast());
    }

    public function testItReadsData(): void
    {
        $page = new Page(2, 1, []);
        $this->assertEquals(1, $page->page());
        $this->assertEquals(2, $page->pages());
    }
}
