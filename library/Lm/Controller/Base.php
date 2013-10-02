<?php

class Lm_Controller_Base {

    private $request;

    private $response;

    public function __contruct(Lm_Controller_Request $resquest, 
            Lm_Controller_Response $response) {
        $this->request = $resquest;
        $this->response = $response;
    }

    /*
    * callback function before action is executed
    */
    void init() {
    }

    /*
    * callback function after action has been executed
    */
    void shutdown() {
    }

    public function getRequest() {
        return $this->request;
    }

    public function getResponse() {
        return $this->response;
    }

    /*
    * handle the controller behaviour before and after action
    */
    public function __call($method, $args) {
        if (!method_exists($method)) {
            throw new Lm_Controller_Exception("Method:".$method." doesn't exist");
        }

        $this->init();
        $this->$method();
        $this->shutdown();

        return $this->response;
    }
}
