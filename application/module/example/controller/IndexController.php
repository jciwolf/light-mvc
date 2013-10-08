<?php

class IndexController extends Lm_Controller_Base {

    public function indexAction() {
        $response = $this->getResponse();
        $response->setTemplateParam("orders", array(1, 2)); 
    }

}// END OF CLASS   
