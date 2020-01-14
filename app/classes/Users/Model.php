<?php

namespace App\Users;
use Core\Database\FileDB;

class Model
{

    private $db;
    private $table_name = 'users';

    public function __construct()
    {
        $this->db = new FileDB(DB_FILE);
        $this->db->createTable($this->table_name);
    }

    public function insert(Users $user){
        $array = $user->getData();
        $this->db->insertRow($this->table_name, $array);
    }

    public function getRows($table_name, $conditions){
        return $this->db->getRowsWhere($table_name, $conditions);
    }


}