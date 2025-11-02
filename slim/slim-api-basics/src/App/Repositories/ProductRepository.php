<?php

declare(strict_types=1);

namespace App\Repositories;

use PDO;
use App\Database;

class ProductRepository
{

  public function __construct(private Database $database)
  {
  }

  public function getAll(): array
  {
    # connect to the database
    $pdo = $this->database->getConnection();

    # prepared sql statement - db query
    $stmt = $pdo->query("SELECT * FROM product");

    # fetch the results of DB query and return results as associative array
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $data;
  }
}