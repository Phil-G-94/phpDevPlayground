<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Repositories\ProductRepository;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class ProductIndex
{
  public function __construct(private ProductRepository $repository)
  {
  }

  public function show(Request $request, Response $response): Response
  {
    $product = $request->getAttribute("product");

    $body = json_encode($product);

    $response->getBody()->write($body);

    return $response;
  }

  public function create(Request $request, Response $response): Response
  {
    $body = $request->getParsedBody();

    $id = $this->repository->addProduct($request, $body);

    $body = json_encode([
      "message" => "Product created",
      "id" => $id
    ]);

    $response->getBody()->write($body);

    return $response;
  }

}