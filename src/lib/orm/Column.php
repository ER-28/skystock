<?php

namespace lib\orm {
    $root = realpath($_SERVER["DOCUMENT_ROOT"]);
    require_once $root . '/lib/orm/Constraint.php';
    
    class Column
    {
        
        /**
         * @param string $name
         * @param string $type
         * @param int $length
         * @param bool $nullable
         * @param bool $primaryKey
         * @param bool $autoIncrement
         * @param array $constraints
         */
        public function __construct(
            public string $name,
            public string $type,
            public int $length,
            public bool $nullable,
            public bool $primaryKey,
            public bool $autoIncrement,
            public array $constraints = []
        ){}
    }
}