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

    public function getById(int $id): array|bool
    {
        $sql = ("SELECT * FROM product WHERE id = :id"); # prepared statement using placehoders - mitigation against SQL injection

        $pdo = $this->database->getConnection();

        $stmt = $pdo->prepare($sql);

        $stmt->bindValue(":id", $id, PDO::PARAM_INT); # bind the value of ":id" in our prepped statement to $id received by the class method

        $stmt->execute(); # executes the statement on the db

        return $stmt->fetch(PDO::FETCH_ASSOC); # return the result as associative array if exits / returns false otherwise
    }
}
