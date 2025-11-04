<?php

declare(strict_types=1);

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Repositories\ProductRepository;

// Alternative way to define route actions
// Instead of defining within callback functions

class ProductsIndex
{

  public function __construct(private ProductRepository $repository)
  {
  }

  public function __invoke(Request $request, Response $response): Response
  {
    $products = $this->repository->getAll();

    $body = json_encode($products);

    $response->getBody()->write($body);

    return $response;
  }
}