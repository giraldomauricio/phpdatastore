<?php

class data_store {

    var $location = ".";
    var $tablesFolder = "tables";
    var $indexFolder = "index";

    function __construct($dir = ".") {
        if(file_exists($dir)) {
            $this->location = $dir;
        }
        if(substr($this->location,-1,1) != "/") {
            $this->location .= "/";
        }
    }

    function check() {
        return file_exists($this->location) ? true:false;
    }

    function create($dir) {
        if(file_exists($dir)) {
            mkdir($dir, 0777);
            return true;
        } else {
            return false;
        }
    }

    function getTables() {
        $result = array();
        if($this->check() && file_exists($this->location.$this->tablesFolder)) {
            $tables = dir($this->location.$this->tablesFolder);
            while (false !== ($entry = $tables->read())) {
                if(substr($entry,0,1) != ".") array_push($result,$entry);
            }
        }
        return $result;
    }

}

?>