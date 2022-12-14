<?php

namespace Alura\Pdo\Infrastructure\Repository;

use Alura\Pdo\Domain\Model\Student;
use Alura\Pdo\Domain\Repository\StudentRepository;
use Alura\Pdo\Infrastructure\Persistence\ConnectionCreator;
use DateTimeImmutable;
use DateTimeInterface;
use Exception;
use PDO;

class PdoStudentRepository implements StudentRepository
{
    private PDO $connection;

    public function __construct()
    {
        $this->connection =  ConnectionCreator::createConnection();
    }

    /**
     * @throws Exception
     */
    public function allStudents(): array
    {
        $sqlSelect = 'SELECT * FROM students;';
        $statement = $this->connection->query($sqlSelect);
        $studentDataList = $statement->fetchAll(PDO::FETCH_ASSOC);
        $studentList = [];

        foreach ($studentDataList as $studentData) $studentList[] = new Student(
            id: $studentData['id'],
            name: $studentData['name'],
            birthDate: new DateTimeImmutable(datetime: $studentData['birth_date'])
        );

        return $studentList;
    }

    /**
     * @throws Exception
     */
    public function studentsBirthAt(DateTimeInterface $birthDate): array
    {
        $sqlSelect = 'SELECT * FROM students WHERE birth_date = :birth_date;';
        $statement = $this->connection->prepare($sqlSelect);
        $statement->bindValue(':birth_date', $birthDate->format('Y-m-d'));
        $statement->execute();

        $studentDataList = $statement->fetchAll(PDO::FETCH_ASSOC);
        $studentList = [];

        foreach ($studentDataList as $studentData) $studentList[] = new Student(
            id: $studentData['id'],
            name: $studentData['name'],
            birthDate: new DateTimeImmutable(datetime: $studentData['birth_date'])
        );

        return $studentList;
    }

    public function save(Student $student): bool
    {
        $sqlInsert = 'INSERT INTO students (name, birth_date) VALUES (:name, :birth_date);';
        $statement = $this->connection->prepare($sqlInsert);
        $statement->bindValue(':name', $student->name());
        $statement->bindValue(':birth_date', $student->birthDate()->format('Y-m-d'));

        return $statement->execute();
    }

    public function remove(Student $student): bool
    {
        $sqlDelete = 'DELETE FROM students WHERE id = :id;';
        $statement = $this->connection->prepare($sqlDelete);
        $statement->bindValue(':id', $student->id(), PDO::PARAM_INT);

        return $statement->execute();
    }
}