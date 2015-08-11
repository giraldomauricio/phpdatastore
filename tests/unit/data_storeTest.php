<?php
/**
 * Created by PhpStorm.
 * User: murdock
 * Date: 8/9/15
 * Time: 8:54 PM
 */

class data_storeTest extends PHPUnit_Framework_TestCase {

    public function testExists() {
        $a = new data_store();
        $this->assertNotNull($a);
    }

    public function testGetTablesRoot() {
        $ds = new data_store("tests/temp/");
        $this->assertEquals($ds->getTablesRoot(),"tests/temp/tables");
    }

    public function testGetIndexRoot() {
        $ds = new data_store("tests/temp/");
        $this->assertEquals($ds->getIndexRoot(),"tests/temp/index");
    }

    public function testDatastoreExists() {
        $ds = new data_store();
        $this->assertTrue($ds->check());
    }

    public function testDatastoreDoesNotExists() {
        $ds = new data_store();
        $ds->location = "foo/bar";
        $this->assertFalse($ds->check());
    }

    public function testCreateDatastore() {
        $ds = new data_store();
        $this->assertFalse($ds->create("/foo/bar"),"Creates a DataStore");
    }

    public function testDataStoreBasicDirectories() {
        $ds = new data_store();
        $this->assertEquals($ds->tablesFolder,"tables","Tables");
        $this->assertEquals($ds->indexFolder,"index","Indexes");
    }

    public function testListTables() {
        $ds = new data_store("tests/temp/");
        $this->assertEquals($ds->getTables(),["orders","transactions"],"List tables");
    }

    public function testCannotAddExistingTable() {
        $ds = new data_store("./tests/temp/");
        $this->assertFalse($ds->createTable("orders"));
    }

    public function testAddAndDeleteExistingTable() {
        $ds = new data_store("./tests/temp/");
        $this->assertTrue($ds->createTable("orders2"),"Table created");
        rmdir($ds->getTablesRoot()."/orders2");
    }

    public function testStoreObjectInTable() {
        $ds = new data_store("./tests/temp/");
        $data = new object("foo");
        $this->assertTrue($ds->store($data,"transactions"),"Data added");
        $this->assertTrue(file_exists("tests/temp/tables/transactions/".$data->id),"Data stored");
        unlink("tests/temp/tables/transactions/".$data->id);
    }

    public function testStoreObjectInTableAndThenReadIt() {
        $ds = new data_store("./tests/temp/");
        $data = new object("foo");
        $this->assertTrue($ds->store($data,"transactions"),"Data added");
        $recovered = $ds->read($data->id,"transactions");
        $this->assertEquals($recovered->id,$data->id,"Data id");
        $this->assertEquals($recovered->data,$data->data,"Data data");
        $this->assertTrue(file_exists("tests/temp/tables/transactions/".$data->id),"Data stored");
        unlink("tests/temp/tables/transactions/".$data->id);
    }

    public function testIndexCreation() {
        $ds = new data_store("./tests/temp/");
        echo "Testing...";
        //$this->assertTrue($ds->createIndex())
    }

}
