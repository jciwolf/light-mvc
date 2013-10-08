<?php

class IndexController extends Lm_Controller_Base {

    public function indexAction() {
        $response = $this->getResponse();
        $response->setBody("Hello World in example module"); 
    }

}// END OF CLASS   
