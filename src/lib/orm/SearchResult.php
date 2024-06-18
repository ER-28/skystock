<?php

namespace lib\orm {
    class SearchResult implements \Countable
    {
        private array $result;

        public function __construct(array $result)
        {
            $this->result = $result;
        }

        public function first(): object | null
        {
            if (count($this->result) === 0) {
                return null;
            }
            
            return $this->result[0];
        }

        public function count(): int
        {
            return count($this->result);
        }
        
        public function arr()
        {
            return $this->result;
        }
    }
}