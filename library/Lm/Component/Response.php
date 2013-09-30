<?php

class Lm_Component_Response {

    private $body = null;

    private $headers = null;

    private $httpCode = 200;

    public function setBody($body) {
        $this->body = $body;
        return;
    }

    public function getBody() {
        return $this->body;
    }

    public function setHttpCode($httpCode) {
        $this->httpCode = $httpCode;
        return;
    }

    public function getHttpCode() {
        return $this->httpCode;
    }

    public function setHeader($key, $value) {
        $this->_headers[] =  array ( $key => $value );
        return;
    }

    public function getHeaders() {
        return $this->_headers;
    }

    public function output() {
        //output header
        foreach ($this->getHeaders as $header) {
            header($header['name'] . ': ' . $header['value']);
        }

        //output http code
        http_response_code($this->getHttpCode());


        //output body
        echo $this->getBody();
    }
}
