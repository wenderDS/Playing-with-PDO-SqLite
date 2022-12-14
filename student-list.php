<?php

require_once "./vendor/autoload.php";

use Alura\Pdo\Infrastructure\Repository\PdoStudentRepository;

$studentRepository = new PdoStudentRepository();

$studentList = [];
try {
    $studentList = $studentRepository->allStudents();
} catch (Exception $e) {
    echo $e->getMessage();
}

print_r($studentList);