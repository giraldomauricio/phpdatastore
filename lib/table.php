<?php

class table {
    var $name;
    var $indexes = array();
    var $ds;

    function __construct($name, $use_ds = true) {
        $this->name = $name;
        $this->ds = new data_store();
        if($use_ds) $this->ds->createTable($name);
    }

    function index($field) {
        array_push($this->indexes,$field);
    }
}