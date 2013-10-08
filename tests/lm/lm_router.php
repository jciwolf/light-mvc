<?php

//load bootstrap
require ("../../application/bootstrap.php");

$router = new Lm_Router("online");
$route = $router->parse("/home_land");
