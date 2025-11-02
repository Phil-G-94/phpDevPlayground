<?php

declare(strict_types=1);

use App\Database;
use Slim\Factory\AppFactory;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

require dirname(__DIR__) . "/vendor/autoload.php";

$app = AppFactory::create(); # instantiate app object

$app->get("/", function (Request $request, Response $response) {
    $response->getBody()->write("Root route");
    return $response;
});

# handle request/response to/from "/api/products"
$app->get("/api/products", function (Request $request, Response $response) {

    require dirname(__DIR__) . "/src/App/Database.php";

    # create a new instance of our Database class (a PDO)
    $database = new Database();

    # connect to the database
    $pdo = $database->getConnection();

    # prepared sql statement - db query
    $stmt = $pdo->query("SELECT * FROM product");

    # fetch the results of DB query and return results as associative array
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    # return JSON
    $body = json_encode($data);

    $response->getBody()->write($body); #send response
    return $response->withHeader("Content-Type", "application/json");
});

$app->get("/test", function (Request $request, Response $response) {
    $response->getBody()->write("Test route");
    return $response;
});

# run the app
$app->run();