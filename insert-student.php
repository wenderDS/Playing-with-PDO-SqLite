<?php

require_once "./vendor/autoload.php";

use Alura\Pdo\Domain\Model\Student;

$databasePath = __DIR__ . "/database.sqlite";
$pdo = new PDO("sqlite:$databasePath");

$student = new Student(
    id: null,
    name: 'Wender Lima',
    birthDate: new DateTimeImmutable('1996-07-22')
);

$sqlInsert = "INSERT INTO students (name, birth_date) 
    VALUES ('{$student->name()}', '{$student->birthDate()->format('Y-m-d')}');";

$result = $pdo->exec($sqlInsert);

var_dump($result);