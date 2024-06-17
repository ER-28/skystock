<?php

abstract class OrmModel
{
    protected $table;
    protected $connection;

    public function __construct($table)
    {
        $this->table = $table;
        $this->connection = new mysqli('localhost', 'root', '', 'test');

        if ($this->connection->connect_error) {
            die('Connection failed: ' . $this->connection->connect_error);
        }

        $this->connection->set_charset('utf8');

        $this->create_table();

        $this->connection->close();
    }

    private function create_table()
    {
        $sql = "CREATE TABLE IF NOT EXISTS $this->table (
            id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        )";

        if ($this->connection->query($sql) === false) {
            die('Error creating table: ' . $this->connection->error);
        }

//        $this->create_columns();
    }

//    private function create_columns()
//    {
//        $columns = $this->columns();
//
//        foreach ($columns as $column) {
//            $sql = "ALTER TABLE $this->table ADD $column";
//
//            if ($this->connection->query($sql) === false) {
//                die('Error creating column: ' . $this->connection->error);
//            }
//        }
//    }

    public function save() {

        $class = new \ReflectionClass($this);
        $tableName = strtolower($class->getShortName());

        $propsToImplode = [];

        foreach ($class->getProperties(\ReflectionProperty::IS_PUBLIC) as $property) { // consider only public properties of the providen
            $propertyName = $property->getName();
            $propsToImplode[] = '`'.$propertyName.'` = "'.$this->{$propertyName}.'"';
        }

        $setClause = implode(',',$propsToImplode); // glue all key value pairs together
        $sqlQuery = '';

        if ($this->id > 0) {
            $sqlQuery = 'UPDATE `'.$tableName.'` SET '.$setClause.' WHERE id = '.$this->id;
        } else {
            $sqlQuery = 'INSERT INTO `'.$tableName.'` SET '.$setClause.', id = '.$this->id;
        }

        return $this->connection->query($sqlQuery);
    }
}