<?php


/*
* http resquest
*/
class Lm_Controller_Request {
 
    //cache for body
    private $rawBody = null;

    //cache for headers
    private $headers = null;
   
    /*
    * retrieve $_GET and $_POST
    *
    * @return array
    */ 
    public function getParams() {
        $ret = array();
        $ret += $_GET;
        $ret += $_POST;
        return $ret;
    }

    /*
    * retrieve a variable of $_GET or $_POST
    *
    * @param string $key Name of the variable
    * @param string $default 
    * @return string
    */
    public function getParam($key, $default = null) {
        if (isset($_GET[$key])) {
            return $_GET[$key];
        } elseif (isset($_POST[$key])) {
            return $_POST[$key];
        }

        return $default;
    }

    public function getCookies() {
        return $_COOKIE;
    }

    public function getCookie($key, $default = null) {
        if (isset($_COOKIE[$key])) {
            return $_COOKIE[$key];
        }
        
        return $default;
    }

    public function getHeaders() {
        //read cache
        if (!empty($this->headers)) {
            return $this->headers;
        }

        $ret = array();
        $headers = array();

        if (function_exists('apache_request_headers')) {
            $headers = apache_request_headers();
        } else {
            $headers = array_merge($_ENV, $_SERVER);

            foreach ($headers as $key => $val) {
                if (strpos(strtolower($key), 'content-type') !== FALSE)
                    continue;
                if (strtoupper(substr($key, 0, 5)) != "HTTP_")
                    unset($headers[$key]);
            }
        }

        foreach ($headers AS $key => $value) {
            $key = preg_replace('/^HTTP_/i', '', $key);
            $key = str_replace(
                    " ",
                    "-",
                    ucwords(strtolower(str_replace(array("-", "_"), " ", $key)))
                );
            $ret[$key] = $value;
        }
        ksort($ret);

        //cache headers
        $this->headers = $ret;
        return $ret;
    }

    public function getRawBody() {
        if (!empty($this->rawBody)) {
            $body = file_get_contents('php://input');

            if (strlen(trim($body)) > 0) {
                $this->rawBody = $body;
            }
        }
        return $this->rawBody;
    }

    public function getHeader($key, $default = null) {
        $headers = $this->getHeaders();
        if (isset($headers[$key])) {
            return $headers[$key];
        }

        return $default;
    }

    public function getServers() {
        return $_SERVER;
    }

    public function getServer($key = null, $default = null) {
        if (isset($_SERVER[$key])) {
            return $_SERVER[$key];
        }

        return $default;
    }

    /*
    * Get the full path of the requested file
    *
    * @return string
    */
    public function getScriptName() {
        return $this->getServer("SCRIPT_NAME");
    }

    /**
     * Get the client's IP addres
     *
     * @param  boolean $checkProxy
     * @return string
     */
    public function getClientIp($checkProxy = true) {
        if ($checkProxy && $this->getServer('HTTP_CLIENT_IP') != null) {
            $ip = $this->getServer('HTTP_CLIENT_IP');
        } else if ($checkProxy && $this->getServer('HTTP_X_FORWARDED_FOR') != null) {
            $ip = $this->getServer('HTTP_X_FORWARDED_FOR');
        } else {
            $ip = $this->getServer('REMOTE_ADDR');
        }

        return $ip;
    }

    /**
     * Is https secure request
     *
     * @return boolean
     */
    public function isSecure() {
        return $this->getServer('HTTPS') == 'on';
    }

}//END OF CLASS
