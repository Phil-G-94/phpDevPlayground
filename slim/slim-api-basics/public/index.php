<?php

declare(strict_types=1);

use App\Middleware\AddJsonResponseHeader;
use Slim\Factory\AppFactory;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use DI\ContainerBuilder;
use Slim\Handlers\Strategies\RequestResponseArgs;

define("APP_ROOT", dirname(__DIR__));

require APP_ROOT . "/vendor/autoload.php";

# DI setup - start #
$builder = new ContainerBuilder();

$container = $builder->addDefinitions(APP_ROOT . "/config/definitions.php")->build();

AppFactory::setContainer($container);

# DI setup - end #

$app = AppFactory::create(); # instantiate app object

# Route strategies - RequestResponseArgs? #

$routeCollector = $app->getRouteCollector();
$routeCollector->setDefaultInvocationStrategy(new RequestResponseArgs());

# Error middleware #
$error_middleware = $app->addErrorMiddleware(true, true, true);
$error_handler = $error_middleware->getDefaultErrorHandler();
$error_handler->forceContentType("application/json"); # return error msgs and logs as JSON

# Content-Type custom middleware #

$app->add(new AddJsonResponseHeader);

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
    return $response;
});

# dynamic route implementation - alt routing strategy #

$app->get("/api/products/{id:[a-z0-9]+}", function (Request $request, Response $response, string $id) {

    $repository = $this->get(App\Repositories\ProductRepository::class);

    $data = $repository->getById((int) $id); # cast the string $id val to int and pass it to the instance of the ProductRepository class

    if ($data === false) {
        throw new \Slim\Exception\HttpNotFoundException($request, message: "404 - product not found!"); # throw exception
    }

    $body = json_encode($data);

    $response->getBody()->write($body);

    return $response;
});

# run the app
$app->run();
