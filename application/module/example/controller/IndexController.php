<?php

class IndexController extends Lm_Controller_Base {

    public function indexAction() {
        $response = $this->getResponse();
        //$response->setTemplateParam("orders", array(1, 2)); 
        $response->setNeedTemplate(false);
        $response->setBody("HelloWorld");
    }

}// END OF CLASS   
