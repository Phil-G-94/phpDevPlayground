<?php

declare(strict_types=1);

use App\Middleware\AddJsonResponseHeader;
use Slim\Factory\AppFactory;
use DI\ContainerBuilder;
use Slim\Routing\RouteCollectorProxy;
use Slim\Handlers\Strategies\RequestResponseArgs;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Controllers\Shops;

define("APP_ROOT", dirname(__DIR__));

require APP_ROOT . "/vendor/autoload.php";

$builder = new ContainerBuilder();

$container = $builder->addDefinitions(APP_ROOT . "/config/definitions.php")->build();

AppFactory::setContainer($container);

// instantiation
$app = AppFactory::create();

// route collection
$routeCollector = $app->getRouteCollector();
$routeCollector->setDefaultInvocationStrategy(new RequestResponseArgs());

// body parses
$app->addBodyParsingMiddleware();

// error middleware
$error_middleware = $app->addErrorMiddleware(true, true, true);
$error_handler = $error_middleware->getDefaultErrorHandler();
$error_handler->forceContentType("application/json");

// custom middleware

# Set content type for all requests / responses to application/json #
$app->add(new AddJsonResponseHeader);

# index route #

$app->get("/", function (Request $request, Response $response) {

  $data = json_encode([
    "message" => "Welcome to the API. Use it sparingly.",
  ]);

  $response->getBody()->write($data);

  return $response;
});

# grouped routes #

$app->group("/api", function (RouteCollectorProxy $group) {
  $group->group("/shops", function (RouteCollectorProxy $group) {
    $group->get("", Shops::class . ":showAllShops");
  });

});

$app->run();