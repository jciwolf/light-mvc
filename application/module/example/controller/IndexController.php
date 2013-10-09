<?php

class IndexController extends Lm_Controller_Base {

    public function indexAction() {
        $response = $this->getResponse();
        $response->setTemplateParam("orders", array(1, 2)); 
    }

    public function noTemplateAction() {
        $response = $this->getResponse();
        $response->setNeedTemplate(false);
        $response->setBody("Hello World");
    }

    public function errorAction() {
        throw new Exception("haha");
    }

}// END OF CLASS   
