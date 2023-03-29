<?php

class Employee
{
    public static string $table = "employee";

    public ?int $employee_id;
    public ?string $name;
    public ?string $surname;
    public ?int $wage;
    public ?int $room;
    public ?string $job;
    public ?string $login;
    public ?string $password;
    public ?int $admin;

    public function __construct(array $rawData = [])
    {
        $this->hydrate($rawData);
    }

    private function hydrate(array $rawData): void
    {
        if (array_key_exists('employee_id', $rawData)) {
            $this->employee_id = $rawData['employee_id'];
        }

        if (array_key_exists('name', $rawData)) {
            $this->name = $rawData['name'];
        }
        if (array_key_exists('surname', $rawData)) {
            $this->surname = $rawData['surname'];
        }
        if (array_key_exists('wage', $rawData)) {
            $this->wage = $rawData['wage'];
        }
        if (array_key_exists('room', $rawData)) {
            $this->room = $rawData['room'];
        }
        if (array_key_exists('job', $rawData)) {
            $this->job = $rawData['job'];
        }
        if (array_key_exists('login', $rawData)) {
            $this->login = $rawData['login'];
        }
        if (array_key_exists('password', $rawData)) {
            $this->password = $rawData['password'];
        }
        if (array_key_exists('admin', $rawData)) {
            $this->admin = $rawData['admin'];
        }
    }

    public static function all(array $sort = []): array
    {
        $pdo = PDOProvider::get();

        $query = "SELECT * FROM `" . self::$table . "` " . self::sortSQL($sort);
        $stmt = $pdo->query($query);

        $result = [];
        while ($employee = $stmt->fetch(PDO::FETCH_ASSOC))
            $result[] = new Employee($employee);

        return $result;
    }

    private static function sortSQL(array $sort): string
    {
        if (!$sort)
            return "";

        $sqlChunks = [];
        foreach ($sort as $column => $direction) {
            $sqlChunks[] = "`$column` $direction";
        }
        return "ORDER BY " . implode(" ", $sqlChunks);
    }

    public function update(): bool {
        // this function updates the database with the stored data
        $pdo = PDOProvider::get();
        $query = "UPDATE `" . self::$table . "` SET `name` = :name, `surname` = :surname, `wage` = :wage, `room` = :room, `job` = :job, `login` = :login, `password` = :password, `admin` = :admin WHERE `employee_id` = :employee_id";
        $stmt = $pdo->prepare($query);
        return $stmt->execute([
            'employee_id' => $this->employee_id,
            'name' => $this->name,
            'surname' => $this->surname,
            'wage' => $this->wage,
            'room' => $this->room,
            'job' => $this->job,
            'login' => $this->login,
            'password' => $this->password,
            'admin' => $this->admin
        ]);
    }
}