<?php

class Lm_Controller_Router {
    const URI_DELIMITER = '/';

    const SPECIAL_DELIMITER = '_';

    const CONTROLLER_SUFFIX = "Controller";

    const ACTION_SUFFIX = "Action";


    private modules = null;

    private defaultModule = null;

    private defaultController = null;

    private defaultAction = null;

    public function __construct($defaultModule, $defaultController, $defaultAction) {
        $this->defaultModule = $defaultModule;
        $this->defaultController = $defaultController;
        $this->defaultAction = $defaultAction;
        return;
    }

    /*
    * match the uri to a specific module, controller, action
    *
    * @param $uri string
    * @return array
    */
    public function parse($uri) {
        if (!empty($uri)) {
            $path = explode(self::URI_DELIMITER, $uri);
            $path = array_shift($path);
            
            $length = count($path);
            if ($length > 3) {
                throw new Lm_Controller_Router_Exception("request error, no script for ".$path);               
            }
            
            $module = "";
            $controller = "";
            $action = "";

            if (!empty($path)) {
                $script = array_pop($path);
                $action = explode(".".$script);               
                $action = $action[0];
            } else {
                $action = $this->defaultAction;
            }

            if (!empty($path)) {
                $controller = array_pop($path);
                $controller
            } else {
                $action = $this->defaultController;
            }

            if (!empty($path)) {
                $script = array_pop($path);
                $action = explode(".".$script);     
                $action = $action[0];
            } else {
                $action = $this->defaultAction;
            }
        }
               
        return 
    }
}
