<?php

$databasePath = __DIR__ . "/database.sqlite";
$pdo = new PDO("sqlite:$databasePath");

echo "Connected!" . PHP_EOL;

$sqlCreate = 'CREATE TABLE students (id INTEGER PRIMARY KEY, name TEXT, birth_date TEXT);';
$pdo->exec($sqlCreate);