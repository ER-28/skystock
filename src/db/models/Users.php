<?php

use lib\orm\OrmModel;

class Users extends OrmModel
{
    public function __construct()
    {
        $this->table = 'users';
        $this->columns = [
            new Column('id', 'int', 11, false, true, true),
            new Column('username', 'varchar', 255, false, false, false),
            new Column('password', 'varchar', 255, false, false, false),
            new Column('email', 'varchar', 255, false, false, false),
            new Column('created_at', 'datetime', 0, true, false, false),
            new Column('updated_at', 'datetime', 0, true, false, false),
        ];

        parent::__construct();
    }

    public static function findByEmail(string $email)
    {
        $users = new Users();
        return $users->where('email', $email)->first();
    }
}