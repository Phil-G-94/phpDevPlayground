<?php

declare(strict_types=1);

use Slim\Factory\AppFactory;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

require dirname(__DIR__) . "/vendor/autoload.php";

$app = AppFactory::create(); # instantiate app object

# handle request/response to/from "/"
$app->get("/api/products", function (Request $request, Response $response) {
    $response->getBody()->write("Hello World!"); #send response
    return $response;
});

$app->get("/test", function (Request $request, Response $response) {
    $response->getBody()->write("Test route");
    return $response;
});

# run the app
$app->run();