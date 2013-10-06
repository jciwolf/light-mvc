<?php

class Lm_Application_Base {

    const CLASSFILE_SUFFIX = '.php';

    const TEMPLATEFILE_SUFFIX = '.tpl';

    const SPECIAL_DELIMITER = '_';

    const APPLICATION_DIR = 'application/'

    const CONFIG_DIR = 'config/';

    const CONFIG_FILE = 'config.ini.php';
 
    const MODULES_DIR = 'module/';

    const CONTROLLER_DIR = 'controller/';

    const TEMPLATE_DIR = 'template/';

    const CONTROLLER_SUFFIX = 'Controller';

    const ACTION_SUFFIX = 'Action';

    private $request = null;

    private $response = null;
   
    private $router = null;

    private $basePath = null;   

    private $configModules = null;
    
    public function __construct($basePath) {
        $this->basePath = $basePath;

        //init
        $this->init();
    }

    public function init() {
        $appConfigFile = $this->basePath."/".self::CONFIG_DIR.self::CONFIG_FILE;     
        if (!file_exist($appConfigFile)) {
            throw new Lm_Application_Exception("Config:".$appConfigFile." doesn't exist");           
        }
        $appConfig = include($appConfigFile);

        //get Config Modules
        if (isset($appConfig['modules']) 
                && !empty($appConfig['modules'])) {
            $this->configModules = $appConfig['modules'];
        } else {
            throw new Lm_Application_Exception("Supported modules must be configured");           
        }

        //define input and output
        $this->request = new Lm_Controller_Request();
        $this->response = new Lm_Controller_Response();

        //the first config module is the default module 
        $this->router = new Lm_Router($this->configModules[0]);
    }

    public function run() {
        $this->dispatch();

        $response = $this->response();
        
    }

    public function dispatch() {
        $route = $this->router->parse($this->request->getScriptName());
        
        $module = $route->getModule();
        $controller = $route->getController();
        $action = $route->getAction();

        //execute handler
        $controller = $this->loadController($module, $controller, $action);
        $response = $controller->$action();

        if ($response->isError()) {
            
        } else {
        }
    }

    private function loadController($module, $controller, $action) {
        $controllerFile = $this->basePath."/".self::MODULES_DIR.self::CONTROLLER_DIR.$controller.".php";
        if (!file_exist($controllerFile)) {
            throw new Lm_Application_NoController("The controller source:".$controllerFile." doesn't exist");
        }
        
        require ($controllerFile);
        if (!class_exists($controller)) {
            throw new Lm_Application_NoController("The controller class:".$controller." doesn't exist");
        }

        $conObj = new $controller(); 
        if !(method_exists($conObj, $action)) {
            throw new Lm_Application_NoAction("The action:".$action." doesn't exist in ".$controller);
        }

        return $conObj;
    }

    private function loadTemplate() {
    }
}
