<?php

namespace Core;

class FileDB  {

    private $file_name;
    private $data;

    public function __construct($file_name)
    {
        $this->file_name = $file_name;
    }

    public  function setData($data){
        $this->data = $data;
    }

    public function save(){
        $encoded_array = json_encode($this->data);
       $bytes_written = file_put_contents($this->file_name, $encoded_array);
       if($bytes_written !== false){
           return true;
       }
       return false;
    }

}
