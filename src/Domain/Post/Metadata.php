<?php
declare(strict_types=1);


namespace InteropApp\Domain\Post;


use Carbon\Carbon;
use Cocur\Slugify\Slugify;

class Metadata
{
    /** @var string */
    private $title;
    /** @var string */
    private $slug;
    /** @var Carbon */
    private $publish;
    /** @var string[] */
    private $tags;

    /**
     * @param string[] $tags
     */
    public function __construct(string $title, ?string $slug, ?Carbon $publish, array $tags)
    {
        $title = trim($title);
        $slug = trim($slug ?? '');

        $this->validate($title);

        $this->title = $title;
        $this->slug = empty($slug) ? $this->makeSlugFromTitle($title) : $slug;
        $this->publish = $publish ?? Carbon::now();
        $this->tags = $tags;
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function slug(): string
    {
        return $this->slug;
    }

    /**
     * @return Carbon
     */
    public function publish(): Carbon
    {
        return $this->publish;
    }

    /**
     * @return string[]
     */
    public function tags(): array
    {
        return $this->tags;
    }

    /**
     * @param string $title
     * @param string $slug
     */
    private function validate(string $title): void
    {
        if (!$title) {
            throw new RequiredMetadataKeyMissed('title');
        }
    }

    private function makeSlugFromTitle(string $title): string
    {
        $s = new Slugify();
        return $s->slugify($title);
    }
}