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

# JSON body parser #

$app->addBodyParsingMiddleware();

# Error middleware #
$error_middleware = $app->addErrorMiddleware(true, true, true);
$error_handler = $error_middleware->getDefaultErrorHandler();
$error_handler->forceContentType("application/json"); # return error msgs and logs as JSON

# Content-Type custom middleware - all requests / responses set to application/json #

$app->add(new AddJsonResponseHeader);

# static route implementation #

$app->get("/", function (Request $request, Response $response) {
    $response->getBody()->write("Root route");
    return $response;
});

$app->get("/api/products", App\Controllers\ProductsIndex::class);

# dynamic route implementation#

$app->get("/api/products/{id:[a-z0-9]+}", App\Controllers\ProductIndex::class . ":show")->add(App\Middleware\GetProduct::class);
# here we are telling Slim to execute the show() method on the ProductIndex class

# specify the mware that should run in response to a get rqst to this route
# we pass in the fully qualified class name instead of a new instance of the class (like we did with AddJsonResponseHeader)
# because ProductRepository is a dependency of the GetProduct class
# and we're using a DI container to resolve dependencies?

$app->post("/api/products/", App\Controllers\ProductIndex::class . ":create");

# run the app
$app->run();


