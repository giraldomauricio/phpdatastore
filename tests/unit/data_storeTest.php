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
        $ds = new data_store();
        $this->assertEquals($ds->getTablesRoot(),$ds->location."tables");
    }

    public function testGetIndexRoot() {
        $ds = new data_store();
        $this->assertEquals($ds->getIndexRoot(),$ds->location."indexes");
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
        $this->assertEquals($ds->indexFolder,"indexes","Indexes");
    }

    public function testListTables() {
        $ds = new data_store();
        $this->assertEquals($ds->getTables(),["orders","transactions"],"List tables");
    }

    public function testCannotAddExistingTable() {
        $ds = new data_store();
        $this->assertFalse($ds->createTable("orders"));
    }

    public function testAddAndDeleteExistingTable() {
        $ds = new data_store();
        $this->assertTrue($ds->createTable("orders2"),"Table created");
        rmdir($ds->getTablesRoot()."/orders2");
    }

    public function testStoreObjectInTable() {
        $ds = new data_store();
        $data = new object("foo");
        $this->assertTrue($ds->store($data,"transactions"),"Data added");
        $this->assertTrue(file_exists("tests/temp/tables/transactions/".$data->id),"Data stored");
        unlink("tests/temp/tables/transactions/".$data->id);
    }

    public function testStoreObjectInTableAndThenReadIt() {
        $ds = new data_store();
        $data = new object("foo");
        $this->assertTrue($ds->store($data,"transactions"),"Data added");
        $recovered = $ds->read($data->id,"transactions");
        $this->assertEquals($recovered->id,$data->id,"Data id");
        $this->assertEquals($recovered->data,$data->data,"Data data");
        $this->assertTrue(file_exists("tests/temp/tables/transactions/".$data->id),"Data stored");
        unlink("tests/temp/tables/transactions/".$data->id);
    }

    public function testIndexCreation() {
        $ds = new data_store();
        $some_table = new table("foo");
        $some_table->indexes = ["field"];
        $some_table->data = ["a" => "b"];
        $ds->store($some_table,$some_table->name);
        $ds->index();
        $this->assertTrue(file_exists($ds->getIndexRoot()."/a.index"));
        unlink("tests/temp/tables/foo/".$some_table->id);
        rmdir($ds->getTablesRoot()."/foo");
        unlink("tests/temp/indexes/a.index");
    }

    public function testMultipleIndexCreation() {
        $ds = new data_store();
        $some_table = new table("foo");
        $some_table->indexes = ["field"];
        $some_table->data = ["a" => "b"];
        $ds->store($some_table,$some_table->name);
        $ds->index();
        //
        $some_table2 = new table("bar");
        $some_table2->indexes = ["field2"];
        $some_table2->data = ["a" => "c"];
        $ds->store($some_table2,$some_table2->name);
        $ds->index();
        //
        $this->assertTrue(file_exists($ds->getIndexRoot()."/a.index"));
        $index = file("tests/temp/indexes/a.index");
        $this->assertEquals(trim($index[0]),"b");
        $this->assertEquals(trim($index[1]),"c");
        //
        unlink("tests/temp/tables/foo/".$some_table->id);
        rmdir($ds->getTablesRoot()."/foo");
        //
        unlink("tests/temp/tables/bar/".$some_table2->id);
        rmdir($ds->getTablesRoot()."/bar");
        //
        unlink("tests/temp/indexes/a.index");
    }

    public function testRetrieveARecord() {
        $ds = new data_store();
        $some_table = new table("foo");
        $some_table->indexes = ["field"];
        $some_table->data = ["a" => "b"];
        $ds->store($some_table,$some_table->name);
        $record = $ds->getById($some_table->id);
        $this->assertEquals($record->data['a'],'b');
        unlink("tests/temp/tables/foo/".$some_table->id);
        rmdir($ds->getTablesRoot()."/foo");
    }

}
