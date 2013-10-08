<?php

class Lm_Application_Base {

    const CLASSFILE_SUFFIX = '.php';

    const TEMPLATEFILE_SUFFIX = '.tpl';

    const SPECIAL_DELIMITER = '_';

    const APPLICATION_DIR = 'application/';

    const CONFIG_DIR = 'config/';

    const CONFIG_FILE = 'config.ini.php';
 
    const MODULE_DIR = 'module/';

    const CONTROLLER_DIR = 'controller/';

    const TEMPLATE_DIR = 'template/';

    private $request = null;

    private $response = null;
   
    private $router = null;

    private $basePath = null;   

    private $configModules = null;
    
    public function __construct($basePath) {
        $this->basePath = rtrim($basePath, "/")."/";

        //init
        $this->init();
    }

    public function init() {
        $appConfigFile = $this->basePath.self::CONFIG_DIR.self::CONFIG_FILE;     
        if (!file_exists($appConfigFile)) {
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

    /*
    * start the application
    */
    public function run() {
        $this->dispatch();
        $this->response->output();
        exit;
    }

    public function dispatch() {
        $route = $this->router->parse($this->request->getScriptName());
        
        //execute handler
        $controller = $this->loadController($route);
        $action = $route->getActionMethodName();
    
        if (!method_exists($controller, $action)) {
            throw new Lm_Application_NoAction("The action:".$action." doesn't exist in ".$controller);
        }
        $controller->$action();
    }

    private function loadController($route) {
        $module = $route->getModule();
        $controller = $route->getController();
        $action = $route->getAction();

        //check module
        if (!in_array($module, $this->configModules)) {
            throw new Lm_Application_NoModule("The module:".$module." hasn't been configured");
        }

        $applicationDir = $this->basePath.self::APPLICATION_DIR;
        $moduleDir = $applicationDir.self::MODULE_DIR.$module."/";
        if (!is_dir($moduleDir)) {
            throw new Lm_Application_NoModule("The module dir:".$moduleDir." does't exist");
        }

        $controllerClass = $route->getControllerClassName();
        $controllerFile = $moduleDir.self::CONTROLLER_DIR.$controllerClass.self::CLASSFILE_SUFFIX;
        if (!file_exists($controllerFile)) {
            throw new Lm_Application_NoController("The controller source:".$controllerFile." doesn't exist");
        }
        
        require_once ($controllerFile);
        if (!class_exists($controllerClass)) {
            throw new Lm_Application_NoController("The controller class:".$controllerClass." doesn't exist");
        }

        $conObj = new $controllerClass($this->request, $this->response); 
        return $conObj;
    }

    private function loadTemplate() {
    }
}
