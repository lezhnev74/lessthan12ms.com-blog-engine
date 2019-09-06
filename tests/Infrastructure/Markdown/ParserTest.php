<?php
declare(strict_types=1);

namespace Tests\Infrastructure\Markdown;

use InteropApp\Domain\Post\RequiredMetadataKeyMissed;
use InteropApp\Infrastructure\Markdown\Parser;
use PHPUnit\Framework\TestCase;

class ParserTest extends TestCase
{
    private $text;
    private $titleLessText;

    public function testItParsesMetaSectionOfTheMDFile(): void
    {
        $parser = new Parser();
        $meta = $parser->parseMeta($this->text);
        $this->assertEquals($meta->title(), 'New Blog Post');
        $this->assertEquals($meta->slug(), 'the-new-blog-post');
        $this->assertEquals($meta->publish()->toIso8601String(), '2019-09-12T12:00:00+00:00');
        $this->assertEquals($meta->tags(), ['php', 'internet', 'api']);
    }

    public function testItReadsBodySectionOfTheMDFile(): void
    {
        $parser = new Parser();
        $body = $parser->parseBody($this->text);

        $expectedBody = <<<BODY
# New Blog Post
The text goes here.
BODY;

        $this->assertEquals($expectedBody, $body);
    }

    public function testItThrowsExceptionWhenNoTitleSet(): void
    {
        $this->expectException(RequiredMetadataKeyMissed::class);
        $this->expectExceptionMessage('title');
        $parser = new Parser();
        $parser->parseMeta($this->titleLessText);
    }

    public function testItReturnsEmptyBodyForTitlessText(): void
    {
        $parser = new Parser();
        $body = $parser->parseBody($this->titleLessText);
        $this->assertEmpty($body);
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->text = <<<MD
slug: the-new-blog-post
publish: 12.09.2019, 12:00
tags: php, internet, api 

# New Blog Post
The text goes here.
MD;

        $this->titleLessText = <<<MD
slug: the-new-blog-post
publish: 12.09.2019, 12:00
tags: php, internet, api 

The text goes here.
MD;
    }
}
