<?php

namespace lib\orm {
    class Column
    {

        /**
         * @param string $name
         * @param string $type
         * @param int $length
         * @param bool $nullable
         * @param bool $primaryKey
         * @param bool $autoIncrement
         */
        public function __construct(
            public string $name,
            public string $type,
            public int $length,
            public bool $nullable,
            public bool $primaryKey,
            public bool $autoIncrement
        ){}
    }
}