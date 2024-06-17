<?php

namespace lib\orm {

    class Query
    {
        private string $table;
        private array $where = [];
        private array $orWhere = [];
        private array $orderBy = [];
        private int $limit = 0;
        private int $offset = 0;
        private OrmModel $model;
        private \mysqli $db;

        public function __construct(OrmModel $model)
        {
            $this->table = $model->table;
            $this->db = $model->db;
            $this->model = $model;
        }

        public function where(string $column, string $value): Query
        {
            $this->where[] = [$column, $value];
            return $this;
        }

        public function orWhere(string $column, string $value): Query
        {
            $this->orWhere[] = [$column, $value];
            return $this;
        }

        public function orderBy(string $column, string $direction): Query
        {
            $this->orderBy[] = [$column, $direction];
            return $this;
        }

        public function limit(int $limit): Query
        {
            $this->limit = $limit;
            return $this;
        }

        public function offset(int $offset): Query
        {
            $this->offset = $offset;
            return $this;
        }

        public function get(): SearchResult
        {
            $query = "SELECT * FROM $this->table";
            $params = [];

            if (count($this->where) > 0) {
                $query .= ' WHERE ';
                foreach ($this->where as $where) {
                    $query .= $where[0] . ' = ? AND ';
                    $params[] = $where[1];
                }
                $query = substr($query, 0, -5);
            }

            if (count($this->orWhere) > 0) {
                $query .= ' OR ';
                foreach ($this->orWhere as $orWhere) {
                    $query .= $orWhere[0] . ' = ? OR ';
                    $params[] = $orWhere[1];
                }
                $query = substr($query, 0, -4);
            }

            if (count($this->orderBy) > 0) {
                $query .= ' ORDER BY ';
                foreach ($this->orderBy as $orderBy) {
                    $query .= $orderBy[0] . ' ' . $orderBy[1] . ', ';
                }
                $query = substr($query, 0, -2);
            }
            if ($this->limit > 0) {
                $query .= ' LIMIT ' . $this->limit;
            }
            if ($this->offset > 0) {
                $query .= ' OFFSET ' . $this->offset;
            }

            $result = $this->db->prepare($query);

            if (count($params) > 0) {
                $types = str_repeat('s', count($params));
                $result->bind_param($types, ...$params);
            }

            $result->execute();

            $return = [];

            foreach ($result->get_result()->fetch_all() as $row) {
                $instance = new $this->model();
                $instance->setData($instance->orderData($row));
                $return[] = $instance;
            }

            return new SearchResult($return);
        }
    }
}