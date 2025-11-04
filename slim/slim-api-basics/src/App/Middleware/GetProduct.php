<?php

declare(strict_types=1);

namespace App\Middleware;

use App\Repositories\ProductRepository;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Routing\RouteContext; # used to obtain route context, i.e. $id in this instance
use Slim\Exception\HttpNotFoundException;

class GetProduct
{

  public function __construct(private ProductRepository $repository) {}

  public function __invoke(Request $request, RequestHandler $handler): Response
  {

    $context = RouteContext::fromRequest($request);

    $route = $context->getRoute();

    $id = $route->getArgument("id");

    $product = $this->repository->getById((int) $id); # cast the string $id val to int and pass it to the instance of the ProductRepository class

    if ($product === false) {
        throw new HttpNotFoundException($request, message: "404 - product not found!"); # throw exception
    }

    $request = $request->withAttribute("product", $product);

    return $handler->handle($request);
  }
}