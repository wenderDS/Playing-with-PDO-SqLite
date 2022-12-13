<?php

require_once "./vendor/autoload.php";

use Alura\Pdo\Domain\Model\Student;

$databasePath = __DIR__ . "/database.sqlite";
$pdo = new PDO("sqlite:$databasePath");

$statement = $pdo->query('SELECT * FROM students;');
$studentDataList = $statement->fetchAll(PDO::FETCH_ASSOC);
$studentList = [];

foreach ($studentDataList as $studentData) $studentList[] = new Student(
    id: $studentData['id'],
    name: $studentData['name'],
    birthDate: new DateTimeImmutable(datetime: $studentData['birth_date'])
);

print_r($studentList);