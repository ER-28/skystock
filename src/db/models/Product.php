<?php
    
    namespace db\models {
        $root = realpath($_SERVER["DOCUMENT_ROOT"]);
        require_once $root . '/lib/orm/OrmModel.php';
        require_once $root . '/lib/orm/Column.php';
        require_once $root . '/lib/orm/Query.php';
        
        use lib\orm\Column;
        use lib\orm\OrmModel;
        use lib\orm\Query;
        
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
                    new Column('category_id', 'int', 11, false, false, false),
                ];
                
                parent::__construct();
            }
        }
    }
    
