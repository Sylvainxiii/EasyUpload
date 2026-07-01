<?php

declare(strict_types=1);

namespace App\Services;

class SqliteService
{
    private static ?SqliteService $instance = null;
    private \PDO $db;
    private string $dbPath;

    public function __construct(?string $dbPath = null)
    {
        if ($dbPath !== null) {
            $this->dbPath = $dbPath;
        } else {
            $dbFile = $_ENV['DB_DATABASE'] ?? 'bdd.db';
            $this->dbPath = rtrim(PROJECT_ROOT, '\\/') . DIRECTORY_SEPARATOR . ltrim($dbFile, '\\/');
        }

        $this->connect();
    }

    private function connect(): void
    {
        $this->db = new \PDO("sqlite:" . $this->dbPath);
        $this->db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        $this->db->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_ASSOC);
    }

    public static function getInstance(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function query(string $sql, array $params = []): \PDOStatement
    {
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }

    public function fetchOne(string $sql, array $params = []): ?array
    {
        $stmt = $this->query($sql, $params);
        $result = $stmt->fetch();
        return $result ?: null;
    }

    public function fetchAll(string $sql, array $params = []): array
    {
        $stmt = $this->query($sql, $params);
        return $stmt->fetchAll();
    }

    public function fetchColumn(string $sql, array $params = [], int $column = 0): mixed
    {
        $stmt = $this->query($sql, $params);
        return $stmt->fetchColumn($column);
    }

    public function execute(string $sql, array $params = []): int
    {
        $stmt = $this->query($sql, $params);
        return $stmt->rowCount();
    }

    public function lastInsertId(): int
    {
        return (int) $this->db->lastInsertId();
    }

    public function beginTransaction(): void
    {
        $this->db->beginTransaction();
    }

    public function commit(): void
    {
        $this->db->commit();
    }

    public function rollback(): void
    {
        $this->db->rollBack();
    }

    public function escape(string $value): string
    {
        return substr($this->db->quote($value), 1, -1);
    }

    public function tableExists(string $tableName): bool
    {
        $sql = "SELECT name FROM sqlite_master WHERE type='table' AND name = :table";
        $result = $this->fetchOne($sql, ['table' => $tableName]);
        return $result !== null;
    }
}
