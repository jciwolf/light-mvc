<?php

class Lm_Controller_Response {

    private $body = null;

    private $headers = null;

    private $httpCode = 200;
 
    //whether need a template or not
    private $needTemplate = true;

    //specify a template
    private $templateName = null;

    //params for template
    private $templateParams = null;

    //cached exception
    private $exception = null;

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

    public function clearHeaders() {
        $this->_headers = null;
        return;
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
        return;
    }

    public function setNeedTemplate($needTemplate) {
        $this->needTemplate = $needTemplate;
        return;
    }

    public function getNeedTemplate() {
        return $this->needTemplate;
    }

    public function setTemplateName($templateName) {
        $this->templateName = $templateName;
        return;
    }

    public function setTemplateParam($key, $value) {
        $this->templateParams += array($key => $value);
        return;
    }

    public function getTemplateParams() {
        return $this->templateParams;
    }

    public function clearTemplateParams() {
        $this->templateParams = null;
        return;
    }

    public function setException(Lm_Exception $e) {
        $this->exception = $e;
        return;
    }

    public function clearException() {
        $this->exception = null;
        return;
    }

    public function isError() {
        return !empty($this->exception);
    }

}// END OF CLASS
