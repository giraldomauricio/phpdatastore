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

}
