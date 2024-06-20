<?php
    
    namespace db\models {
        $root = realpath($_SERVER["DOCUMENT_ROOT"]);
        require_once $root . '/lib/orm/OrmModel.php';
        require_once $root . '/lib/orm/Column.php';
        require_once $root . '/lib/orm/Query.php';
        
        use lib\orm\Column;
        use lib\orm\OrmModel;
        use lib\orm\Query;
        
        class Categories extends OrmModel
        {
            public function __construct()
            {
                $this->table = 'categories';
                $this->columns = [
                    new Column('id', 'int', 11, false, true, true),
                    new Column('name', 'varchar', 255, false, false, false),
                ];
                
                parent::__construct();
            }
        }
    }
    
