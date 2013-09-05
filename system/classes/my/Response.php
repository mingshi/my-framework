<?php
/**
  * process Http Response
  */
class MY_Response {
    public function __construct() {
    }

    public function __destruct() {
    }

    public function set_cookie($name, $value, $expire = 0, $path = NULL, $domain = NULL, $secure = FALSE, $httpOnly = FALSE) {
        $config = $GLOBALS['config'];
        if (!$path) {
            $path = $config['cookie_path'];
        }

        if (!$domain) {
            $domain = $config['cookie_domain'];
        }

        return setcookie($name, $value,
            $expire ? time() + intval($expire) : 0,
            $path, $domain,
            $secure, $httponly);
    }

    public function remove_cookie($name, $path=NULL, $domain=NULL, $secure=FALSE, $httponly=FALSE) {
        return $this->set_cookie($name, NULL, -3600, $path, $domain, $secure, $httponly);
    }

    public function set_header($name, $value, $http_reponse_code=NULL) {
        header("$name: $value", TRUE, $http_reponse_code);
    }

    public function add_header($name, $value, $http_reponse_code=NULL) {
        header("$name: $value", FALSE, $http_reponse_code);
    }

    public function set_content_type($content_type, $charset=NULL) {
        if (!$charset && preg_match('/^text/i', $content_type)) {
            $charset = $GLOBALS['config']['charset'];
            if (!$charset) {
                $charset = 'utf-8';
            }
        }
        if ($charset) {
            $this->set_header("content-type", "$content_type; charset=$charset");
        } else {
            $this->set_header("content-type", $content_type);
        }
    }

    public function set_cache_control($value) {
        $this->set_header("cache-control", $value);
    } 

    // TODO: client Side Cache ?

    
}
