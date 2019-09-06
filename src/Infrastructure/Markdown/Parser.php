<?php
declare(strict_types=1);


namespace InteropApp\Infrastructure\Markdown;


use Carbon\Carbon;
use InteropApp\Domain\Post\Metadata;

class Parser
{
    public function parseMeta(string $text): Metadata
    {
        $lines = $this->readMetaLines($text);
        $kv = [];
        foreach ($lines as $l) {
            if (preg_match('#^(tags|publish|slug):\s(.*)$#', $l, $p)) {
                $value = $p[2];
                if ($p[1] === 'publish') {
                    $value = Carbon::parse($value);
                } elseif ($p[1] === 'tags') {
                    $value = array_map('trim', explode(',', $value));
                }
                $kv[$p[1]] = $value;
            }
        }

        $titleLine = $this->readTitleLine($text);
        if ($titleLine) {
            $kv['title'] = substr($titleLine, 1);
        }

        $metadata = new Metadata(
            $kv['title'] ?? '',
            $kv['slug'] ?? '',
            $kv['publish'] ?? null,
            $kv['tags'] ?? [],
        );

        return $metadata;
    }

    public function parseBody(string $text): string
    {
        $body = '';
        $delim = "\n";
        $line = strtok($text, $delim);
        $titleLineDetected = false;

        while ($line !== false) {
            $titleLineDetected = ($titleLineDetected || $this->isTitleLine($line));
            if ($titleLineDetected) {
                $body .= $line . "\n";
            }
            $line = strtok($delim);
        }

        return trim($body);
    }

    /**
     * @return string[]
     */
    private function readMetaLines(string $text): array
    {
        $lines = [];
        $delim = "\n";

        $line = strtok($text, $delim);
        while ($line !== false) {

            if (strncmp($line, '#', 1) === 0) {
                break;
            }
            $lines[] = $line;

            $line = strtok($delim);
        }

        return $lines;
    }

    private function readTitleLine(string $text): ?string
    {
        $delim = "\n";
        $line = strtok($text, $delim);
        while ($line !== false) {
            if ($this->isTitleLine($line)) {
                return $line;
            }
            $line = strtok($delim);
        }

        return null;
    }

    private function isTitleLine(string $line): bool
    {
        return (bool)preg_match('/^#[^#]/', $line);
    }
}