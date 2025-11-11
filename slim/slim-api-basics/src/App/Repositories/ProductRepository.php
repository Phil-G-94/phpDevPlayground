<?php

declare(strict_types=1);

namespace App\Repositories;

use PDO;
use App\Database;
use PDOStatement;

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

    public function addProduct(array $data): PDOStatement|string
    {
      $sql = (
        "INSERT INTO product (name, description, size)
         VALUES (:name, :description, :size)
        "
      );

      $pdo = $this->database->getConnection();

      $stmt = $pdo->prepare($sql);

      $stmt->bindValue(":name", $data["name"], PDO::PARAM_STR);

      if (empty($data["description"])) {
        $stmt->bindValue(":description", $data["description"], PDO::PARAM_NULL);
      } else {
        $stmt->bindValue(":description", $data["description"], PDO::PARAM_STR);
      }

      $stmt->bindValue(":size", $data["size"], PDO::PARAM_INT);

      $stmt->execute();

      return $pdo->lastInsertId();
    }

    public function updateProduct(int $id, array $data): PDOStatement|int
    {

      $sql = (
        "UPDATE product
         SET name = :name, description = :description, size = :size
         WHERE id = :id
        "
      );

      $pdo = $this->database->getConnection();

      $stmt = $pdo->prepare($sql);

      $stmt->bindValue(":name", $data["name"], PDO::PARAM_STR);

      if (empty($data["description"])) {
        $stmt->bindValue(":description", $data["description"], PDO::PARAM_NULL);
      } else {
        $stmt->bindValue(":description", $data["description"], PDO::PARAM_STR);
      }

      $stmt->bindValue(":size", $data["size"], PDO::PARAM_INT);

      $stmt->bindValue(":id", $id, PDO::PARAM_INT);

      $stmt->execute();

      return $stmt->rowCount(); # return num of rows updated
    }

    public function deleteProduct(int $id): PDOStatement|int
    {
      $sql = (
        "DELETE FROM product
        WHERE id = :id
        "
      );

      $pdo = $this->database->getConnection();

      $stmt = $pdo->prepare($sql);

      $stmt->bindValue(":id", $id, PDO::PARAM_INT);

      $stmt->execute();

      return $stmt->rowCount(); # return num of rows deleted;
    }
}
