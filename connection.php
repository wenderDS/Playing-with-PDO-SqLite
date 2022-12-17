<?php

require_once "./vendor/autoload.php";

use Alura\Pdo\Infrastructure\Persistence\ConnectionCreator;

$pdo = ConnectionCreator::createConnection();

echo "Connected!" . PHP_EOL;

$pdo->exec("
    INSERT INTO phones (area_code, number, student_id) 
        VALUES ('65', '99299-9999', 1),
               ('65', '99299-9998', 1),
               ('65', '99299-9997', 3),
               ('65', '99299-9996', 4),
               ('65', '99299-9995', 5)
");
exit();
$sqlCreate = '
    CREATE TABLE IF NOT EXISTS students (
        id INTEGER PRIMARY KEY, 
        name TEXT, 
        birth_date TEXT
    );

    CREATE TABLE IF NOT EXISTS phones (
        id INTEGER PRIMARY KEY,
        area_code TEXT,
        number TEXT,
        student_id INTEGER,
        FOREIGN KEY (student_id) REFERENCES students(id) 
    );
';
$pdo->exec($sqlCreate);