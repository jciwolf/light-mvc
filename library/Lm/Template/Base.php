<?php

class Lm_Template_Base {

    private $templateFilePath = null;
    private $response = null;

    public function __construct($templateFilePath, Lm_Controller_Response $response) {
        if (!file_exists($templateFilePath)) {
            throw new Lm_Template_Exception();
        }
        $this->templateFilePath = $templateFilePath;
        $this->response = $response;
    }

    public function getResponse() {
        return $this->response;
    }

    public function load() {
        $response = $this->getResponse();

        $params = $response->getTemplateParams();
        if (!empty($params)) {
            extract($params);
        }
 
        //parse the template       
        ob_start();
        include($this->templateFilePath);
        $content = ob_get_clean();

        $response->setBody($content);
        return;
    }
}
