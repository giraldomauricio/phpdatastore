<?php

date_default_timezone_set('America/Los_Angeles');

class data_store {

    var $location;
    var $tablesFolder = "tables";
    var $indexFolder = "indexes";
    var $root = ".";
    var $config;
    var $object;

    function __construct() {
        if(defined("DS_ROOT")) {
            if(file_exists(DS_ROOT)) {
                $this->location = DS_ROOT."/";
            } else {
                throw new Exception("Datastore does not exist.");
            }
        } else {
            throw new Exception("Datastore is not set.");
        }
    }

    function getTablesRoot(){
        return $this->location.$this->tablesFolder;
    }

    function getIndexRoot(){
        return $this->location.$this->indexFolder;
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
        if($this->check() && file_exists($this->getTablesRoot())) {
            $tables = dir($this->getTablesRoot());
            while (false !== ($entry = $tables->read())) {
                if(substr($entry,0,1) != ".") array_push($result,$entry);
            }
        }
        return $result;
    }

    function createTable($table_name) {
        if(!file_exists($this->getTablesRoot()."/".$table_name)){
            mkdir($this->getTablesRoot()."/".$table_name, 0777);
            return true;
        }
        else {
            return false;
        }
    }

    function store($object, $table_name) {
        $this->object = $object;
        $s = serialize($object);
        if(file_put_contents($this->getTablesRoot()."/".$table_name."/".$object->id, $s)) {
            return true;
        } else {
            return false;
        }
    }

    function storeIndex($key, $value) {
        $fh = fopen($this->getIndexRoot()."/".$key.".index", 'a');
        fwrite($fh, $value.PHP_EOL);
        fclose($fh);
    }

    function read($id, $table_name) {
        $s = file_get_contents($this->getTablesRoot()."/".$table_name."/".$id);
        return unserialize($s);
    }

    function index() {
        foreach ($this->object->data as $key => $value) {
            $this->storeIndex($key, $value);
        }
    }

    function getById($id) {
        return $this->read($id, $this->object->name);
    }

}

?>