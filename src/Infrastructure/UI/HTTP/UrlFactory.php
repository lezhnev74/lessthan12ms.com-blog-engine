<?php
declare(strict_types=1);


namespace InteropApp\Infrastructure\UI\HTTP;


use InteropApp\Domain\Post\Metadata;
use Webmozart\Assert\Assert;

class UrlFactory
{
    /** @var string */
    protected $baseUrl;

    public function __construct(string $baseUrl)
    {
        Assert::notEq(false, filter_var($baseUrl, FILTER_VALIDATE_URL), 'Base url is not valid');
        $this->baseUrl = $baseUrl;
    }

    public function makePostUrl(Metadata $metadata): string
    {
        return sprintf('%s/%s.html', $this->baseUrl, $metadata->slug());
    }

    public function makePageUrl(int $page): string
    {
        return sprintf('%s/page/%d.html', $this->baseUrl, $page);
    }
}