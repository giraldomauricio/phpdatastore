<?php

include_once('AutoLoader.php');
// Register the directory to your include files
AutoLoader::registerDirectory('./lib/');
//AutoLoader::registerDirectory('./PHPUnit/Framework/');
define("DS_ROOT", realpath(dirname(__FILE__)."/../tests/temp/"));