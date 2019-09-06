<?php
declare(strict_types=1);


namespace InteropApp\Domain\Post;


class MarkdownPost
{
    /** @var string */
    protected $body;
    /** @var Metadata */
    protected $meta;

    /**
     * @param string $text
     * @param Metadata $meta
     */
    public function __construct(string $text, Metadata $meta)
    {
        $this->body = $text;
        $this->meta = $meta;
    }


    public function getBody(): string { return $this->body; }

    /**
     * @return Metadata
     */
    public function meta(): Metadata
    {
        return $this->meta;
    }


}