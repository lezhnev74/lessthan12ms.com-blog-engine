<?php
declare(strict_types=1);

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Slim\Factory\AppFactory;

require_once __DIR__ . '/../vendor/autoload.php';
require_once projectRoot() . '/src/Infrastructure/main.php';

$http = AppFactory::create();

$http->get('/', function (RequestInterface $request, ResponseInterface $response, $args) {
    $response->getBody()->write('Hello world!');
    return $response;
});

$http->run();