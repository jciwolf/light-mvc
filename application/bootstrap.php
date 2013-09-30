<?php

// Ensure library/ is in include_path
set_include_path(implode(PATH_SEPARATOR, array(
    realpath(dirname(__FILE__))."/../library/",
    get_include_path(),
)));

// Autoload class
require 'Lm/Autoloader.php';
$loader = Lm_Autoloader::getInstance();
$loader->init();
