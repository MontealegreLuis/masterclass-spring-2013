<?php
set_include_path(get_include_path() . PATH_SEPARATOR . realpath('../lib'));
chdir(__DIR__ . '/../');

use \Utils\Autoloader;

require_once 'lib/Utils/Autoloader.php';
$autoloader = new Autoloader('lib/');
$autoloader->register();

$framework = new MasterController(require_once 'config/config.php');

$framework->execute();