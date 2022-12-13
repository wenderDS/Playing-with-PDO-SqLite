<?php

require_once "./vendor/autoload.php";

use Alura\Pdo\Domain\Model\Student;

$databasePath = __DIR__ . "/database.sqlite";
$pdo = new PDO("sqlite:$databasePath");

$student = new Student(
    id: null,
    name: "Papaléguas Blindão",
    birthDate: new DateTimeImmutable('1983-03-25')
);

$sqlInsert = "INSERT INTO students (name, birth_date) VALUES (:name, :birth_date);";
$statement = $pdo->prepare($sqlInsert);
$statement->bindValue(':name', $student->name());
$statement->bindValue(':birth_date', $student->birthDate()->format('Y-m-d'));

if ($statement->execute()) {
    echo "Student Included!";
}