<?php

abstract class Lm_Controller_Base {

    private $request;

    private $response;

    public function __construct(Lm_Controller_Request $request, 
            Lm_Controller_Response $response) {
        $this->setRequest($request);
        $this->setResponse($response);
    }

    /*
    * callback function before action is executed
    */
    public function init() {
    }

    /*
    * callback function after action has been executed
    */
    public function shutdown() {
    }

    public function getRequest() {
        return $this->request;
    }

    public function setRequest(Lm_Controller_Request $request) {
        $this->request = $request;
        return;
    }


    public function getResponse() {
        return $this->response;
    }

    public function setResponse(Lm_Controller_Response $response) {
        $this->response = $response;
        return;
    }

    /*
    * handle the controller behaviour before and after action
    */
    public function __call($method, $args) {
        if (!method_exists($this, $method)) {
            throw new Lm_Controller_Exception("Method:".$method." doesn't exist");
        }

        $response = $this->getResponse();

        $this->init();
        try {
            $this->$method();
        } catch (Exception $e) {//default error handling
            $response->setException($e);   
        }
        $this->shutdown();
 
        return $response;
    }

}//END OF CLASS
