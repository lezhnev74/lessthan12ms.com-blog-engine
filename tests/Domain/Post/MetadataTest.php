<?php
declare(strict_types=1);

namespace Tests\Domain\Post;

use Carbon\Carbon;
use InteropApp\Domain\Post\Metadata;
use PHPUnit\Framework\TestCase;

class MetadataTest extends TestCase
{

    public function testItGeneratesSlugItself(): void
    {
        $title = 'Hello, Friend!';
        $expectedSlug = 'hello-friend';

        $m = new Metadata($title, '', null, []);
        $this->assertEquals($expectedSlug, $m->slug());
    }

    public function testItSetsDefaultPublishDateToNow(): void
    {
        Carbon::setTestNow(Carbon::now());

        $m = new Metadata('a', null, null, []);
        $this->assertTrue(Carbon::now()->eq($m->publish()));
    }
}
