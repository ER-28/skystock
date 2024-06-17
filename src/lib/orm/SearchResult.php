<?php

namespace lib\orm {
    class SearchResult implements \Countable
    {
        private array $result;

        public function __construct(array $result)
        {
            $this->result = $result;
        }

        public function first(): object
        {
            return $this->result[0];
        }

        public function count(): int
        {
            return count($this->result);
        }
    }
}