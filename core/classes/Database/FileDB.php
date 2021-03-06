<?php

namespace Core\Database;

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

    public function updateRow($table_name, $row, $row_id)
    {
        if ($this->rowExists($table_name, $row_id)) {
            $this->data[$table_name][$row_id] = $row;
            return true;
        }
        return false;
    }

    public function deleteRow($table_name, $row_id)
    {
        if ($this->rowExists($table_name, $row_id)) {
            unset($this->data[$table_name][$row_id]);
            return true;
        }
        return false;
    }

    public function getRow($table_name, $row_id)
    {
        return $this->data[$table_name][$row_id];
    }

    /**
     * @param string $table
     * @param array $conditions
     * @return array|bool
     */
    public function getRowsWhere(string $table, array $conditions)
    {
        if (!$this->tableExists($table)) return false;
        $ret = [];
        foreach ($this->data[$table] as $index => $row) {
            $status = true;
            foreach ($conditions as $con_key => $con_value) {
                var_dump($con_value);
                if ($con_key === 'row_id') {
                    if ($index != $con_value) $status = false;
                } elseif ($row[$con_key] !== $con_value) {
                    $status = false;
                }
            }
            if ($status) $ret[$index] = $row;
        }
        return $ret;
    }

//    public function insertData($table_name, )

    public function __destruct()
    {
        $this->save();
    }


}
