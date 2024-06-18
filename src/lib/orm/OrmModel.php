<?php

namespace lib\orm {
    $root = realpath($_SERVER["DOCUMENT_ROOT"]);
    require_once $root . '/lib/orm/SearchResult.php';
    require_once $root . '/db/models/Users.php';
    require_once $root . '/db/models/QuerySave.php';
    
    use db\models\QuerySave;
    use lib\orm\SearchResult;
    use Exception;

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

            $this->createTable();
            $this->checkColumns();
        }
        
        /**
         * @return void
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
            }
            $sql = rtrim($sql, ',');
            $sql .= ')';
            $this->db->query($sql);
            $this->add_constraint();
        }
        
        /**
         * @return void
         */
        public function add_constraint()
        {
            $sql = "ALTER TABLE $this->table ";
            foreach ($this->columns as $column) {
                foreach ($column->constraints as $constraint) {
                    if ($constraint->type === ConstraintType::FOREIGN_KEY) {
                        $sql .= "ADD CONSTRAINT $constraint->name FOREIGN KEY ($constraint->key) REFERENCES $constraint->reference ON DELETE $constraint->onDelete ON UPDATE $constraint->onUpdate,";
                    }
                }
            }
            $sql = rtrim($sql, ',');
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
                    $this->db->query($sql);
                }
            }
        }
        
        /**
         * @return void
         */
        public function save(): void
        {
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
        
        /**
         * @return void
         */
        public function delete(): void
        {
            $sql = "DELETE FROM $this->table WHERE id = " . $this->data['id'];
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
            $this->data = $data;
        }
    }
}