<?php

declare (strict_types=1);

namespace App\Repositories;

use App\Database;
use PDO;
use PDOStatement;

class ShopRepository
{

  public function __construct(private Database $db)
  {
  }

  public function getAll(): array
  {
    $pdo = $this->db->getConnection();

    $stmt = $pdo->query("SELECT * FROM shops");

    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $data;
  }
}