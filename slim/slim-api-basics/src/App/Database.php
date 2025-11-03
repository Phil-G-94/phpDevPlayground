<?php

declare(strict_types=1);

namespace App;

use PDO;

class Database
{
    public function __construct(
        private string $host,
        private string $name,
        private string $user,
        private string $password
    ) {
    }

    public function getConnection(): PDO
    {
      # define the data source name (DSN) "{DSNprefix}host={hostname};dbname={dbName};charset={dbCharset}"
        $dsn = "mysql:host=$this->host;dbname=$this->name;charset=utf8";

      # instantiates new PDO object
        $pdo = new PDO($dsn, $this->user, $this->password, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

        return $pdo;
    }
};
