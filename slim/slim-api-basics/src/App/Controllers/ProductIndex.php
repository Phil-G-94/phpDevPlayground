<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Repositories\ProductRepository;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Valitron\Validator; # validation pkg #

class ProductIndex
{
  public function __construct(private ProductRepository $repository, private Validator $validator)
  {
    # validation rules #
    $this->validator->mapFieldRules('name', ['required']);
    $this->validator->mapFieldRules('size', ['required', 'integer', ['min', 1]]);
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

    $this->validator = $this->validator->withData($body);

    # user input validation #
    if ( ! $this->validator->validate()) {
      $response->getBody()->write(json_encode($this->validator->errors()));
      return $response->withStatus(422);
    }

    $id = $this->repository->addProduct($body);

    $body = json_encode([
      "message" => "Product created",
      "id" => $id
    ]);

    $response->getBody()->write($body);

    return $response;
  }

}