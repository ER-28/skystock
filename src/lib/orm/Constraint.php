<?php
    
    namespace lib\orm {
        
        enum ConstraintType
        {
            case FOREIGN_KEY;
        }
        
        class Constraint
        {
            
            /**
             * Constraint constructor.
             * @param string $name
             * @param ConstraintType $type
             * @param array $key
             * @param OrmModel $reference
             * @param array $referenceKey
             * @param string $onUpdate
             * @param string $onDelete
             * @return void
             */
            public function __construct(
                public string $name,
                public ConstraintType $type,
                public array $key,
                public OrmModel $reference,
                public array $referenceKey,
                public string $onUpdate,
                public string $onDelete
            ){}
        }
    }