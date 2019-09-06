<?php
declare(strict_types=1);

// Load environment variables from .env
$dotenv = Dotenv\Dotenv::create(projectRoot());
$dotenv->load();

// initialize a container
$builder = new \DI\ContainerBuilder();
$builder->useAutowiring(false);
$builder->useAnnotations(false);
if (!env('DEVELOPER_MODE')) {
    $builder->enableCompilation(projectRoot() . '/tmp');
}
$container = $builder->build();