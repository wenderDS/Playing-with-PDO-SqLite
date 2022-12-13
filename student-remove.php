<?php

require_once "./vendor/autoload.php";

$databasePath = __DIR__ . "/database.sqlite";
$pdo = new PDO("sqlite:$databasePath");

$sqlStudentDelete = "DELETE FROM students WHERE id = :id;";
$statement = $pdo->prepare($sqlStudentDelete);
$statement->bindValue(':id', 2, PDO::PARAM_INT);
$result = $statement->execute();

if ($result) {
    echo "Student removed!";
}