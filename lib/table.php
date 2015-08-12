<?php

class table extends object{
    var $name;
    var $indexes = array();
    var $ds;

    function __construct($name, $use_ds = true) {
        parent::__construct( );
        $this->name = $name;
        $this->ds = new data_store();
        if($use_ds) $this->ds->createTable($name);
    }

    function index($field) {
        array_push($this->indexes,$field);
    }
}