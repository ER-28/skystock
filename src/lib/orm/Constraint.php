<?php
    
    namespace lib\orm {
        
        enum ConstraintType
        {
            case PRIMARY_KEY;
            case FOREIGN_KEY;
        }
        
        class Constraint
        {
            
            /**
             *
             */
            public function __construct(
                public string $name,
                public ConstraintType $type,
                public string $key,
                public string $reference,
                public string $onUpdate,
                public string $onDelete
            ){}
        }
    }