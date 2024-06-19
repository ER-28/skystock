<?php

namespace lib\orm {
    $root = realpath($_SERVER["DOCUMENT_ROOT"]);
    require_once $root . '/lib/SaveRequest.php';
    use Exception;
    
    use lib\SaveRequest;

    abstract class OrmModel
    {
        public string $table;
        public array $columns;
        public mixed $data;
        public \mysqli $db;

        /**
         * @throws Exception
         */
        public function __construct() {
            try {
                $this->db = new \mysqli('db', 'isitech', 'isitech', 'isitech');
            } catch (\Exception $e) {
                throw new \Exception('Error creating a database connection ');
            }

            $sql = "SHOW TABLES LIKE '$this->table'";
            SaveRequest::save($sql);
            $result = $this->db->query($sql);
            if ($result->num_rows === 0) {
                $this->createTable();
            }
            $this->checkColumns();
        }
        
        /**
         * @return void
         * @throws Exception
         */
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
                foreach ($column->constraints as $constraint) {
                    $referenceName = $constraint->reference->table;
                    if ($constraint->type === ConstraintType::FOREIGN_KEY) {
                        $keys = implode(',', $constraint->key);
                        $referenceKeys = implode(',', $constraint->referenceKey);
                        
                        $sql .= "CONSTRAINT $constraint->name FOREIGN KEY ($keys) REFERENCES $referenceName ($referenceKeys)";
                        if ($constraint->onUpdate) {
                            $constraint->onUpdate = 'NO ACTION';
                        }
                        if ($constraint->onDelete) {
                            $constraint->onDelete = 'NO ACTION';
                        }
                    }
                }
            }
            $sql = rtrim($sql, ',');
            $sql .= ')';
            SaveRequest::save($sql);
            $this->db->query($sql);
        }
        
        /**
         * @return void
         */
        private function checkColumns(): void
        {
            $sql = "SHOW COLUMNS FROM $this->table";
            $result = $this->db->query($sql);
            $columns = $result->fetch_all();
            $column_names = [];
            foreach ($columns as $column) {
                $column_names[] = $column[0];
            }
            foreach ($this->columns as $column) {
                if (!in_array($column->name, $column_names)) {
                    $sql = "ALTER TABLE $this->table ADD COLUMN " . $column->name . ' ' . $column->type . '(' . $column->length . ')';
                    if ($column->primaryKey) {
                        $sql .= ' PRIMARY KEY';
                    }
                    if ($column->autoIncrement) {
                        $sql .= ' AUTO_INCREMENT';
                    }
                    if (!$column->nullable) {
                        $sql .= ' NOT NULL';
                    }
                    SaveRequest::save($sql);
                    $this->db->query($sql);
                }
            }
        }
        
        /**
         * @return void
         * @throws Exception
         */
        public function delete(): void
        {
            $sql = "DELETE FROM $this->table WHERE id = " . $this->data['id'];
            SaveRequest::save($sql);
            $this->db->query($sql);
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
            foreach ($data as $key => $value) {
                if ($value !== null) {
                    $this->data[$key] = $this->db->real_escape_string($value);
                }
            }
        }
        
        public function update(): void
        {
            $sql = "UPDATE $this->table SET ";
            foreach ($this->data as $key => $value) {
                $sql .= "$key = '$value', ";
            }
            $sql = rtrim($sql, ', ');
            $sql .= " WHERE id = " . $this->data['id'];
            SaveRequest::save($sql);
            $this->db->query($sql);
        }
        
        public function save(): void
        {
            $sql = "INSERT INTO $this->table (";
            $keys = '';
            $values = '';
            foreach ($this->data as $key => $value) {
                $keys .= $key . ', ';
                $values .= "'$value', ";
            }
            $keys = rtrim($keys, ', ');
            $values = rtrim($values, ', ');
            $sql .= $keys . ') VALUES (' . $values . ')';
            SaveRequest::save($sql);
            $this->db->query($sql);
        }
    }
}