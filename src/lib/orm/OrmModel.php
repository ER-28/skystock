<?php

require_once "SearchResult.php";

abstract class OrmModel
{
    public string $table;
    public array $columns;
    public $data;
    private \mysqli $db;

    /**
     * @throws Exception
     */
    public function __construct() {
        try {
            $this->db = new \mysqli('db', 'isitech', 'isitech', 'isitech');
        } catch (\Exception $e) {
            throw new \Exception('Error creating a database connection ');
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
        $this->db->query($sql);
    }

    public function update(): void
    {
        //create row or update row if exists
        $sql = "INSERT INTO $this->table (";
        foreach ($this->data as $key => $value) {
            $sql .= $key . ',';
        }
        $sql = rtrim($sql, ',');
        $sql .= ') VALUES (';
        foreach ($this->data as $key => $value) {
            $sql .= "'$value',";
        }
        $sql = rtrim($sql, ',');
        $sql .= ') ON DUPLICATE KEY UPDATE ';
        foreach ($this->data as $key => $value) {
            $sql .= $key . "='$value',";
        }
        $sql = rtrim($sql, ',');
        $this->db->query($sql);
    }

    public function delete(): void
    {
        $sql = "DELETE FROM $this->table WHERE id = " . $this->data['id'];
        $this->db->query($sql);
    }

    public function where(string $column, string $value): SearchResult
    {
        $sql = "SELECT * FROM $this->table WHERE $column = '$value'";
        $result = $this->db->query($sql);

        $return = [];

        foreach ($result->fetch_all() as $row) {
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