<?php

namespace KPZadatak\Core\DB;

use KPZadatak\Core\DB\Contracts\DatabaseInterface;
use PDO;

class MySqlDB implements DatabaseInterface
{
    private string $host;
    private string $user;
    private string $pass;
    private string $dbname;
    private PDO $pdo;

    public function __construct()
    {
        $this->host = $_ENV['MYSQL_HOST'];
        $this->user = $_ENV['MYSQL_USER'];
        $this->pass = $_ENV['MYSQL_PASSWORD'];
        $this->dbname = $_ENV['MYSQL_DATABASE'];

        $dsn = "mysql:host=$this->host;dbname=$this->dbname";
        $this->pdo = new PDO($dsn, $this->user, $this->pass);
    }

    /**
     * @param $table
     * @param $data
     *
     * @return bool
     */
    public function create($table, $data): ?int
    {
        $columns = implode(',', array_keys($data));
        $placeholders = implode(',', array_fill(0, count($data), '?'));

        $sql = "INSERT INTO $table ($columns) VALUES ($placeholders)";
        $success = $this->executeUpdate($sql, array_values($data));

        if ($success) {
            return $this->pdo->lastInsertId();
        }

        return false;
    }


    /**
     * @param $table
     * @param $where
     * @param array $params
     *
     * @return bool|\PDOStatement
     */
    public function read($table, $where = null, array $params = []): bool|\PDOStatement
    {
        $sql = "SELECT * FROM $table";
        if ($where) {
            $sql .= " WHERE $where";
        }
        return $this->executeQuery($sql, $params);
    }

    /**
     * @param $table
     * @param $where
     * @param array $params
     *
     * @return mixed
     */
    public function readOne($table, $where, array $params = []): mixed
    {
        $sql = "SELECT * FROM $table WHERE $where LIMIT 1";
        $result = $this->executeQuery($sql, $params);
        return $result->fetch();
    }

    /**
     * @param $table
     * @param $data
     * @param $where
     * @param array $params
     *
     * @return bool
     */
    public function update($table, $data, $where, array $params = []): bool
    {
        $updates = array_map(function ($key) {
            return "$key=?";
        }, array_keys($data));
        $sql = "UPDATE $table SET " . implode(',', $updates) . " WHERE $where";
        $params = array_merge(array_values($data), $params);
        return $this->executeUpdate($sql, $params);
    }

    /**
     * @param $table
     * @param $where
     * @param array $params
     *
     * @return bool
     */
    public function delete($table, $where, array $params = []): bool
    {
        $sql = "DELETE FROM $table WHERE $where";
        return $this->executeUpdate($sql, $params);
    }

    /**
     * @param $sql
     * @param $params
     *
     * @return false|\PDOStatement
     */
    private function executeQuery($sql, $params = [])
    {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }

    /**
     * @param $sql
     * @param $params
     *
     * @return bool
     */
    private function executeUpdate($sql, $params = [])
    {
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute($params);
    }
}
