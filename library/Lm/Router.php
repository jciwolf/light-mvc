<?php

class Lm_Router {

    private $defaultModule = null;

    private $defaultController = "index";

    private $defaultAction = "index";

    public function __construct($defaultModule) {
        $this->defaultModule = $defaultModule;
    }

    /*
    * match the uri to a specific module, controller, action
    *
    * @param $uri string
    * @return array
    */
    public function parse($uri) {
        $route = new Lm_Router_Route;

        $path = explode(DIRECTORY_SEPARATOR, trim($uri, DIRECTORY_SEPARATOR));

        $length = count($path);
        if ($length > 3) {
            throw new Lm_Router_Exception("request error, no script for ".$path);               
        }
        
        //extract action   
        if (!empty($path)) {
            $script = array_pop($path);
            $action = explode(".", $script);               
            $route->setAction(strtolower($action[0]));
        } else {
            $route->setAction($this->defaultAction);
        }

        //extract controller
        if (!empty($path)) {
            $controller = array_pop($path);
            $route->setController(strtolower($controller));
        } else {
            $route->setController($this->defaultController);
        }

        if (!empty($path)) {
            $module = array_pop($path);
            $route->setModule(strtolower($module));
        } else {
            $route->setModule($this->defaultModule);
        }
               
        return $route;
    }
}// END OF CLASS
