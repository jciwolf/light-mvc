<?php

class Lm_Autoloader {
    
    private static $loader;    

    public static function getInstance() {    
        if (self::$loader == NULL) {
            self::$loader = new self;
        }
            
        return self::$loader;    
    }    

    public function init() {
        spl_autoload_register(array($this, "autoload"));
        return;
    }

    private function autoload($clazz) {
        $paths = explode(PATH_SEPARATOR, get_include_path());
        $filename = str_replace('_', '/', $clazz);

        foreach ($paths as $path) {           
            $combined = $path.DIRECTORY_SEPARATOR.$file;
            if (is_file($combined)) {       
                include($combined);
                return;
            }
        }
    }
}// END OF CLASS
