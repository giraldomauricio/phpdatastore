<?php
/**
 * Created by PhpStorm.
 * User: murdock
 * Date: 8/9/15
 * Time: 8:54 PM
 */

class config_managerTest extends PHPUnit_Framework_TestCase {

    public function testExists() {
        $a = new config_manager();
        $this->assertNotNull($a);
    }


}
