<?php

declare(strict_types=1);

use Slim\Factory\AppFactory;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use DI\ContainerBuilder;

define("APP_ROOT", dirname(__DIR__));

require APP_ROOT . "/vendor/autoload.php";

$builder = new ContainerBuilder();

$container = $builder->addDefinitions(APP_ROOT . "/config/definitions.php")->build();

AppFactory::setContainer($container);

$app = AppFactory::create(); # instantiate app object

# static route implementation #

$app->get("/", function (Request $request, Response $response) {
    $response->getBody()->write("Root route");
    return $response;
});

$app->get("/api/products", function (Request $request, Response $response) {

    $repository = $this->get(App\Repositories\ProductRepository::class); # dependency injection

    $data = $repository->getAll();

    $body = json_encode($data);

    $response->getBody()->write($body); #send response
    return $response->withHeader("Content-Type", "application/json");
});

# dynamic route implementation #
# {id} - variable route based on a product's id
# :[...] regexp pattern matching for route, will only recognise specified char values / types

$app->get("/api/products/{id:[a-z0-9]+}", function (Request $request, Response $response, array $args) {
    $id = $args["id"];

    $response->getBody()->write($id);

    return $response;
});

# run the app
$app->run();