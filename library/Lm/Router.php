<?php

class Lm_Controller_Router {
    const URI_DELIMITER = '/';

    const SPECIAL_DELIMITER = '_';

    const CONTROLLER_SUFFIX = "Controller";

    const ACTION_SUFFIX = "Action";

    private $defaultModule = null;

    private $defaultController = "IndexController";

    private $defaultAction = "indexAction";

    public function __construct(string $defaultModule) {
        $this->defaultModule = $defaultModule;
    }

    /*
    * match the uri to a specific module, controller, action
    *
    * @param $uri string
    * @return array
    */
    public function parse(string $uri) {
        $route = new Lm_Router_Route;

        $path = explode(self::URI_DELIMITER, $uri);
        $path = array_shift($path);
            
        $length = count($path);
        if ($length > 3) {
            throw new Lm_Router_Exception("request error, no script for ".$path);               
        }
        
        //extract action   
        if (!empty($path)) {
            $script = array_pop($path);
            $action = explode(".".$script);               
            $route->setAction($action[0].self::ACTION_SUFFIX);
        } else {
            $route->setAction($this->defaultAction);
        }

        //extract controller
        if (!empty($path)) {
            $controller = array_pop($path);
            $route->setController($controller.self::CONTROLLER_SUFFIX);
        } else {
            $route->setController($this->defaultController);
        }

        if (!empty($path)) {
            $module = array_pop($path);
            $route->setModule($module);
        } else {
            $route->setModule($this->defaultModule);
        }
               
        return $route;
    }
}// END OF CLASS
