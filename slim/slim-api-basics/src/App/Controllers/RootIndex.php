<?php

declare(strict_types=1);

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class RootIndex
{

  public function __invoke(Request $request, Response $response): Response
  {

    $data = json_encode([
      "message" => "Welcome to the Products API. Please use the CRUD functionality responsibly."
    ]);

    $response->getBody()->write($data);

    return $response;
  }

};