<?php
    
    namespace db\models {
        $root = realpath($_SERVER["DOCUMENT_ROOT"]);
        require_once $root . '/lib/orm/OrmModel.php';
        require_once $root . '/lib/orm/Column.php';
        require_once $root . '/lib/orm/Query.php';
        require_once $root . '/lib/orm/Constraint.php';
        require_once $root . '/db/models/Categories.php';
        
        use lib\orm\Column;
        use lib\orm\Constraint;
        use lib\orm\ConstraintType;
        use lib\orm\OrmModel;
        
        class Product extends OrmModel
        {
            public function __construct()
            {
                $this->table = 'product';
                $this->columns = [
                    new Column('id', 'int', 11, false, true, true),
                    new Column('name', 'varchar', 255, false, false, false),
                    new Column('price', 'decimal', 10, false, false, false),
                    new Column('stock', 'int', 11, false, false, false),
                    new Column('category_id', 'int', 11, false, false, false, [
                        new Constraint(
                            'product_categories_fk',
                            ConstraintType::FOREIGN_KEY,
                            ['category_id'],
                            new Categories(),
                            ['id'],
                            'CASCADE',
                            'CASCADE'
                        )
                    ]),
                ];
                
                parent::__construct();
            }
        }
    }
    
