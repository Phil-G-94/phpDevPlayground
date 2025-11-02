<?php

declare(strict_types=1);

namespace App;

use PDO;

class Database
{
  public function getConnection(): PDO {
    # define the data source name (DSN) "{DSNprefix}host={hostname};dbname={dbName};charset={dbCharset}"
    $dsn = "mysql:host=127.0.0.1;dbname=slimapidb;charset=utf8";

    # instantiates new PDO object
    $pdo = new PDO($dsn, "root", "", [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

    return $pdo;
  }
};