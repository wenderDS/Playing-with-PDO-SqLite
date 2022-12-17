<?php

require_once "./vendor/autoload.php";

use Alura\Pdo\Infrastructure\Persistence\ConnectionCreator;
use Alura\Pdo\Infrastructure\Repository\PdoStudentRepository;

$connection = ConnectionCreator::createConnection();
$studentRepository = new PdoStudentRepository($connection);

$studentList = [];
try {
    $studentList = $studentRepository->studentsWithPhones();
} catch (Exception $e) {
    echo $e->getMessage();
}

print_r($studentList);