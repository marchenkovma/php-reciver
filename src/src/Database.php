<?php

declare(strict_types=1);

use PDO;

class Database
{
    private PDO $pdo;

    public function __construct()
    {
        $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
        $dotenv->load();

        $host = $_ENV['DB_HOST'];
        $database = $_ENV['DB_DATABASE'];
        $username = $_ENV['DB_USERNAME'];
        $password = $_ENV['DB_PASSWORD'];

        $dsn = "mysql:host=$host;dbname=$database";
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ];

        try {
            $this->pdo = new PDO($dsn, $username, $password, $options);
        } catch (PDOException $e) {
            throw new RuntimeException('Ошибка подключения к базе данных: ' . $e->getMessage(), 0, $e);
        }
    }

    public function query(string $sql, array $params = []): PDOStatement
    {
        $statement = $this->pdo->prepare($sql);
        $statement->execute($params);

        return $statement;
    }

    public function fetchAll(string $sql, array $params = []): array
    {
        $statement = $this->query($sql, $params);

        return $statement->fetchAll();
    }

    public function fetchOne(string $sql, array $params = []): ?array
    {
        $statement = $this->query($sql, $params);

        return $statement->fetch();
    }

    public function lastInsertId(): int
    {
        return $this->pdo->lastInsertId();
    }
}

<?php

require 'vendor/autoload.php';

$database = new Database();

$results = $database->fetchAll('SELECT * FROM users');

foreach ($results as $result) {
    echo $result['name'] . PHP_EOL;
}
