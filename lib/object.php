<?php

class object {
    var $created;
    var $id;
    var $data;

    function __construct($data = null) {
        $this->created = date("Ymdhis");
        $this->id = uniqid();
        $this->data = $data;
    }

}