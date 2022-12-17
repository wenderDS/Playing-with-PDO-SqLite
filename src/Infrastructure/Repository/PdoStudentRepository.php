<?php

namespace Alura\Pdo\Infrastructure\Repository;

use Alura\Pdo\Domain\Model\Phone;
use Alura\Pdo\Domain\Model\Student;
use Alura\Pdo\Domain\Repository\StudentRepository;
use DateTimeImmutable;
use DateTimeInterface;
use Exception;
use PDO;
use PDOStatement;
use RuntimeException;

class PdoStudentRepository implements StudentRepository
{
    private PDO $connection;

    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @throws Exception
     */
    public function allStudents(): array
    {
        $sqlSelect = 'SELECT * FROM students;';
        $statement = $this->connection->query($sqlSelect);

        return $this->hydrateStudentList($statement);
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

        return $this->hydrateStudentList($statement);
    }

    public function save(Student $student): bool
    {
        if ($student->id() === null) {
            return $this->insert($student);
        }

        return $this->update($student);
    }

    private function insert(Student $student): bool
    {
        $sqlInsert = "INSERT INTO students (name, birth_date) VALUES (:name, :birth_date);";
        $statement = $this->connection->prepare($sqlInsert);

        $result = $statement->execute([
            ':name' => $student->name(),
            ':birth_date' => $student->birthDate()->format('Y-m-d')
        ]);

        if ($result) $student->defineId($this->connection->lastInsertId());

        return $result;
    }

    private function update(Student $student): bool
    {
        $sqlInsert = 'UPDATE students SET name = :name, birth_date = :birth_date WHERE id = :id;';
        $statement = $this->connection->prepare($sqlInsert);
        $statement->bindValue(':name', $student->name());
        $statement->bindValue(':birth_date', $student->birthDate()->format('Y-m-d'));
        $statement->bindValue(':id', $student->id(), PDO::PARAM_INT);

        return $statement->execute();
    }

    public function remove(Student $student): bool
    {
        $sqlDelete = 'DELETE FROM students WHERE id = :id;';
        $statement = $this->connection->prepare($sqlDelete);
        $statement->bindValue(':id', $student->id(), PDO::PARAM_INT);

        return $statement->execute();
    }

    /**
     * @throws Exception
     */
    private function hydrateStudentList(PDOStatement $statement): array
    {
        $studentDataList = $statement->fetchAll(PDO::FETCH_ASSOC);
        $studentList = [];

        foreach ($studentDataList as $studentData) {
            $studentList[] = new Student(
                id: $studentData['id'],
                name: $studentData['name'],
                birthDate: new DateTimeImmutable(datetime: $studentData['birth_date'])
            );
        }

        return $studentList;
    }

    private function fillPhonesOf(Student $student): void
    {
        $sqlSelect = 'SELECT id, area_code, number FROM phones WHERE student_id = :student_id;';
        $statement = $this->connection->prepare($sqlSelect);
        $statement->bindValue(':student_id', $student->id(), PDO::PARAM_INT);
        $statement->execute();
        $phonesList = $statement->fetchAll(PDO::FETCH_ASSOC);

        foreach ($phonesList as $phone) $student->addPhone(
            new Phone(
                id: $phone['id'],
                areaCode: $phone['area_code'],
                number: $phone['number']
            )
        );
    }

    /**
     * @throws Exception
     */
    public function studentsWithPhones(): array
    {
        $sqlSelect = '
            SELECT 
                student.id AS student_id, 
                student.name, 
                student.birth_date,
                phone.id AS phone_id,
                phone.area_code,
                phone.number
            FROM students AS student
                INNER JOIN phones phone ON student.id = phone.student_id
            ;    
        ';

        $statement = $this->connection->query($sqlSelect);
        $result = $statement->fetchAll();
        $studentList = [];

        foreach ($result as $row) {
            if (!array_key_exists($row['student_id'], $studentList)) {
                $studentList[$row['student_id']] = new Student(
                    $row['student_id'],
                    $row['name'],
                    new DateTimeImmutable($row['birth_date'])
                );
            }

            $studentList[$row['student_id']]->addPhone(
                new Phone(
                    $row['phone_id'],
                    $row['area_code'],
                    $row['number'],
                )
            );
        }

        return $studentList;
    }
}
