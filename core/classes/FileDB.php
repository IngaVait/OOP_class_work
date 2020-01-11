<?php

namespace Core;

class FileDB
{

    private $file_name;
    private $data;

    public function __construct($file_name)
    {
        $this->file_name = $file_name;
    }

    public function setData($data)
    {
        $this->data = $data;
    }

    public function save()
    {
        $encoded_array = json_encode($this->data);
        $bytes_written = file_put_contents($this->file_name, $encoded_array);
        if ($bytes_written !== false) {
            return true;
        }
        return false;
    }

    public function load()
    {
        if (file_exists($this->file_name)) {
            $this->data = json_decode(file_get_contents($this->file_name), true);
        } else {
            $this->data = [];
        }
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }


    public function createTable($table_name)
    {
        if (!$this->tableExists($table_name)) {
            $this->data[$table_name] = [];
            return true;
        }
        return false;
    }

    public function tableExists($table_name)
    {
        return isset($this->data[$table_name]);
    }

    public function dropTable($table_name)
    {
        if ($this->tableExists($table_name)) {
            unset($this->data[$table_name]);
            return true;
        }
        return false;
    }

    public function truncateTable($table_name)
    {
        if ($this->tableExists($table_name)) {
            $this->data[$table_name] = [];
            return true;
        }
        return false;
    }

    public function insertRow($table_name, $row, $row_id = null)
    {
        if ($this->tableExists($table_name)) {
            $this->data[$table_name][$row_id ?? (count($this->data[$table_name])) + 1] = $row;
            $row_id = array_key_last($this->data[$table_name]);
            return $row_id;
        }
        return false;
    }

    public function rowExists($table_name, $row_id)
    {
        return isset($this->data[$table_name][$row_id]);
    }

    public function insertRowIfNotExists($table_name, $row, $row_id)
    {
        if (!$this->rowExists($table_name, $row_id)) {
            $this->insertRow($table_name, $row, $row_id);
            return $row_id;
        }
        return false;
    }


}
