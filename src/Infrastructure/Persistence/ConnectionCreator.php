<?php

namespace Alura\Pdo\Infrastructure\Persistence;

use PDO;

class ConnectionCreator
{
    public static function createConnection(): PDO
    {
        $databasePath = __DIR__ . "./../../../database.sqlite";
        return new PDO("sqlite:$databasePath");
    }
}