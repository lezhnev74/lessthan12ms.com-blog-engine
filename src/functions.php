<?php

use Dotenv\Environment\Adapter\EnvConstAdapter;
use Dotenv\Environment\Adapter\PutenvAdapter;
use Dotenv\Environment\Adapter\ServerConstAdapter;
use Dotenv\Environment\DotenvFactory;
use PhpOption\Option;

function projectRoot(): string { return realpath(dirname(__DIR__)); }

function env($key, $default = null)
{
    static $variables;

    if ($variables === null) {
        $variables = (new DotenvFactory([
            new EnvConstAdapter,
            new PutenvAdapter,
            new ServerConstAdapter
        ]))->createImmutable();
    }

    return Option::fromValue($variables->get($key))
        ->map(function ($value) {
            switch (strtolower($value)) {
                case 'true':
                case '(true)':
                    return true;
                case 'false':
                case '(false)':
                    return false;
                case 'empty':
                case '(empty)':
                    return '';
                case 'null':
                case '(null)':
                    return null;
            }

            if (preg_match('/\A([\'"])(.*)\1\z/', $value, $matches)) {
                return $matches[2];
            }

            return $value;
        })
        ->getOrCall(function () use ($default) {
            return $default;
        });
}