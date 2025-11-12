<?php

declare(strict_types=1);

use App\Middleware\AddJsonResponseHeader;
use Slim\Factory\AppFactory;
use DI\ContainerBuilder;
use Slim\App;
use Slim\Handlers\Strategies\RequestResponseArgs;
use App\Controllers\ProductIndex;
use App\Controllers\ProductsIndex;
use App\Controllers\RootIndex;
use Slim\Routing\RouteCollectorProxy;

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

$app->get("/", RootIndex::class);

# grouping routes #
# we can group routes that use the same root path #

$app->group("/api", function (RouteCollectorProxy $group) {

    $group->get("/products", ProductsIndex::class);


    $group->post("/products",ProductIndex::class . ":create");

    # we can also group routes that use the same middleware #
    $group->group("", function (RouteCollectorProxy $group) {

        # dynamic route implementation#
        $group->get("/products/{id:[0-9]+}", ProductIndex::class . ":show");
        # here we are telling Slim to execute the show() method on the ProductIndex class
        # specify the mware that should run in response to a get rqst to this route
        # we pass in the fully qualified class name instead of a new instance of the class (like we did with AddJsonResponseHeader)
        # because ProductRepository is a dependency of the GetProduct class
        # and we're using a DI container to resolve dependencies?

        $group->patch("/products/{id:[0-9]+}", ProductIndex::class . ":update");

        $group->delete("/products/{id:[0-9]+}", ProductIndex::class . ":delete");

    })->add(\App\Middleware\GetProduct::class);

});


# run the app
$app->run();


