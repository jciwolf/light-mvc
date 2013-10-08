<?php

class Lm_Router_Route {

    const SPECIAL_DELIMITER = '_';

    const CONTROLLER_SUFFIX = 'Controller';

    const ACTION_SUFFIX = 'Action';

    private $module = null;

    private $controller = null;

    private $action = null;

    public function setModule($module) {
        $this->module = $module;
        return;
    }
    
    public function getModule() {
        return $this->module;
    }

    public function setController($controller) {
        $this->controller = $controller;
        return;
    }

    public function getController() {
        return $this->controller;
    }

    public function setAction($action) {
        $this->action = $action;
        return;
    }

    public function getAction() {
        return $this->action;
    }

    public function getControllerClassName() {
        $parts = explode(self::SPECIAL_DELIMITER, $this->controller);
        $className = "";
        foreach($parts as $part) {
            $className .= ucwords($part);
        }

        return $className.self::CONTROLLER_SUFFIX;
    }

    public function getActionMethodName() {
        $parts = explode(self::SPECIAL_DELIMITER, $this->action);
        $methodName = array_shift($parts);
        foreach($parts as $part) {
            $methodName .= ucwords($part);
        }
    
        return $methodName.self::ACTION_SUFFIX;
    }

}//END OF CLASS
