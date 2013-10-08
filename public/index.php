<?php

//load bootstrap
require ("../application/bootstrap.php");

//start application
$application = new Lm_Application_Base(realpath(dirname(__FILE__))."/../");
$application->run();
