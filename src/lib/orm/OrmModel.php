<?php

namespace lib\orm;

use Exception;
use PDO;
use PDOException;
use Users;

abstract class OrmModel
{
    public string $table;
    public array $columns;
    public mixed $data;
    private PDO $db;

    /**
     * @throws Exception
     */
    public function __construct()
    {
        try {
            $this->db = new PDO('mysql:host=db;dbname=isitech', 'isitech', 'isitech');
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            throw new Exception('Error creating a database connection: ' . $e->getMessage());
        }

        $this->createTable();
    }

    public function createTable(): void
    {
        $sql = "CREATE TABLE IF NOT EXISTS $this->table (";
        foreach ($this->columns as $column) {
            $sql .= $column->name . ' ' . $column->type . '(' . $column->length . ')';
            if ($column->primaryKey) {
                $sql .= ' PRIMARY KEY';
            }
            if ($column->autoIncrement) {
                $sql .= ' AUTO_INCREMENT';
            }
            if (!$column->nullable) {
                $sql .= ' NOT NULL';
            }
            $sql .= ',';
        }
        $sql = rtrim($sql, ',');
        $sql .= ')';

        $this->db->exec($sql);
    }

    public function update(): void
    {
        $sql = "INSERT INTO $this->table (";
        $params = [];
        foreach ($this->data as $key => $value) {
            $sql .= $key . ',';
            $params[":$key"] = $value; // Use named parameters
        }
        $sql = rtrim($sql, ',');
        $sql .= ') VALUES (';
        foreach ($params as $key => $value) {
            $sql .= $key . ',';
        }
        $sql = rtrim($sql, ',');
        $sql .= ') ON DUPLICATE KEY UPDATE ';
        foreach ($params as $key => $value) {
            $sql .= str_replace(':', '', $key) . "=$key,";
        }
        $sql = rtrim($sql, ',');

        $stmt = $this->db->prepare($sql); // Prepare the statement
        $stmt->execute($params); // Execute with parameters
    }

    public function delete(): void
    {
        $sql = "DELETE FROM $this->table WHERE id = :id";
        $stmt = $this->db->prepare($sql); // Prepare the statement
        $stmt->execute([':id' => $this->data['id']]); // Bind parameter
    }

    public function where(string $column, string $value): SearchResult
    {
        $sql = "SELECT * FROM $this->table WHERE $column = :value";
        $stmt = $this->db->prepare($sql); // Prepare the statement
        $stmt->execute([':value' => $value]); // Bind parameter

        $return = [];

        foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
            $user = new Users();
            $user->setData($row);
            $return[] = $user;
        }

        return new SearchResult($return);
    }

    /**
     * @return mixed
     */
    public function getData(): mixed
    {
        return $this->data;
    }

    /**
     * @param mixed $data
     */
    public function setData(mixed $data): void
    {
        $this->data = $data;
    }
}