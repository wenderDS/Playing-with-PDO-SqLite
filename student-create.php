<?php

require_once "./vendor/autoload.php";

use Alura\Pdo\Domain\Model\Student;
use Alura\Pdo\Infrastructure\Repository\PdoStudentRepository;

$student = new Student(
    id: null,
    name: "Jubileu Bonaparte",
    birthDate: new DateTimeImmutable('1993-02-28')
);

$studentRepository = new PdoStudentRepository();
$result = $studentRepository->save($student);

if ($result) {
    echo "Student Included!";
}