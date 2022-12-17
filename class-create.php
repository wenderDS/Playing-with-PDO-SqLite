<?php

require_once "./vendor/autoload.php";

use Alura\Pdo\Domain\Model\Student;
use Alura\Pdo\Infrastructure\Persistence\ConnectionCreator;
use Alura\Pdo\Infrastructure\Repository\PdoStudentRepository;

$connection = ConnectionCreator::createConnection();
$studentRepository = new PdoStudentRepository($connection);

$connection->beginTransaction();

try {
    $oneStudent = new Student(
        null,
        'Nico Tokita',
        new DateTimeImmutable('1985-05-01')
    );
    $studentRepository->save($oneStudent);

    $anotherStudent = new Student(
        null,
        'Jubileu Perna Torta',
        new DateTimeImmutable('1985-05-01')
    );
    $studentRepository->save($anotherStudent);

    $connection->commit();
} catch (PDOException $e) {
    echo $e->getMessage();
    $connection->rollBack();
}