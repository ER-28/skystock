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
             * @param string $key
             * @param string $reference
             * @param string $referenceKey
             * @param string $onUpdate
             * @param string $onDelete
             * @return void
             */
            public function __construct(
                public string $name,
                public ConstraintType $type,
                public string $key,
                public string $reference,
                public string $referenceKey,
                public string $onUpdate,
                public string $onDelete
            ){}
        }
    }