<?php

class Route {

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

}//END OF CLASS
