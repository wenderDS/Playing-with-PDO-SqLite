<?php

use Alura\Pdo\Infrastructure\Persistence\ConnectionCreator;

$pdo = ConnectionCreator::createConnection();

echo "Connected!" . PHP_EOL;

$sqlCreate = 'CREATE TABLE students (id INTEGER PRIMARY KEY, name TEXT, birth_date TEXT);';
$pdo->exec($sqlCreate);