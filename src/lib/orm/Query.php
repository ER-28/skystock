<?php

namespace lib\orm {
    
    
    $root = realpath($_SERVER["DOCUMENT_ROOT"]);
    require_once $root . '/lib/orm/SearchResult.php';
    require_once $root . '/lib/SaveRequest.php';
    
    use lib\orm\SearchResult;
    use lib\SaveRequest;
    
    class Query
    {
        private string $table;
        private array $columns;
        private array $select = [];
        private array $where = [];
        private array $orWhere = [];
        private array $orderBy = [];
        private int $limit = 0;
        private int $offset = 0;
        private OrmModel $model;
        private \mysqli $db;

        /**
         * Query constructor.
         * @param OrmModel $model
         */
        public function __construct(OrmModel $model)
        {
            $this->table = $model->table;
            $this->db = $model->db;
            $this->columns = $model->columns;
            $this->model = $model;
        }
        
        /**
         * @param string $column
         * @param string $value
         * @return $this
         */
        public function where(string $column, string $value): Query
        {
            $this->where[] = [$column, $value];
            return $this;
        }
        
        /**
         * @param string $column
         * @param string $value
         * @return $this
         */
        public function orWhere(string $column, string $value): Query
        {
            $this->orWhere[] = [$column, $value];
            return $this;
        }
        
        /**
         * @param string $column
         * @param string $direction
         * @return $this
         */
        public function orderBy(string $column, string $direction): Query
        {
            $this->orderBy[] = [$column, $direction];
            return $this;
        }
        
        /**
         * @param int $limit
         * @return $this
         */
        public function limit(int $limit): Query
        {
            $this->limit = $limit;
            return $this;
        }
        
        /**
         * @param int $offset
         * @return $this
         */
        public function offset(int $offset): Query
        {
            $this->offset = $offset;
            return $this;
        }
        
        /**
         * @param array $string
         * @return $this
         */
        public function select(array $string): Query
        {
            $this->select = $string;
            return $this;
        }
        
        /**
         * @return SearchResult<OrmModel>
         * @throws \Exception
         */
        public function get(): SearchResult
        {
            $query = "SELECT ";
            $params = [];
            
            if (count($this->select) > 0) {
                foreach ($this->select as $select) {
                    $query .= $select . ', ';
                }
                $query = substr($query, 0, -2);
            } else {
                $query .= '*';
            }
            
            $query .= ' FROM ' . $this->table;

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
            
            SaveRequest::save($query);
            $result = $this->db->prepare($query);

            if (count($params) > 0) {
                $types = str_repeat('s', count($params));
                $result->bind_param($types, ...$params);
            }

            $result->execute();

            $return = [];

            foreach ($result->get_result()->fetch_all() as $row) {
                $instance = new $this->model();
                $instance->setData($this->queryOrderData($row, selected: $this->select));
                $return[] = $instance;
            }

            return new SearchResult($return);
        }
        
        /**
         * @param array $array
         * @param array $selected
         * @return array
         */
        function queryOrderData(array $array, array $selected): array
        {
            $used_selected = $selected;
            if (count($selected) === 0) {
                $used_selected = [];
                for ($i = 0; $i < count($array); $i++) {
                    $used_selected[] = $this->columns[$i]->name;
                }
            }
            
            $ordered = [];
            for ($i = 0; $i < count($array); $i++) {
                $ordered[$used_selected[$i]] = $array[$i];
            }
            return $ordered;
        }
    }
}