<?php

declare (strict_types=1);

namespace App\Controllers;

use App\Repositories\ShopRepository;
use Slim\Psr7\Request;
use Slim\Psr7\Response;
use PDOStatement;

class Shops
{
  public function __construct(private ShopRepository $repository)
  {

  }

  public function showAllShops(Request $request, Response $response): Response
  {
    $shops = $this->repository->getAll();

    $body = json_encode($shops);

    $response->getBody()->write($body);

    return $response;
  }

}