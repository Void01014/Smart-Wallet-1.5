<?php
class database{
    private PDO $pdo;

    public function __construct(
        string $host,
        string $dbname,
        string $user,
        string $pass
    ) {
        $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";

        try {
            $this->pdo = new PDO(
                $dsn,
                $user,
                $pass,
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                ]
            );
        } catch (PDOException $e) {
            die("DB connection failed");
        }
    }
    public function getConnection(): PDO {
        return $this->pdo;
    }
}
