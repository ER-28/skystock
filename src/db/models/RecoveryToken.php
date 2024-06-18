<?php

namespace db\models {
    $root = realpath($_SERVER["DOCUMENT_ROOT"]);
    require_once $root . '/lib/orm/OrmModel.php';
    require_once $root . '/lib/orm/Column.php';

    use lib\orm\Column;
    use lib\orm\OrmModel;

    class RecoveryToken extends OrmModel
    {
        public function __construct()
        {
            $this->table = 'recover_tokens';
            $this->columns = [
                new Column('id', 'int', 11, false, true, true),
                new Column('username', 'varchar', 255, false, false, false),
                new Column('token', 'varchar', 255, false, false, false),
            ];

            parent::__construct();
        }
    }
}