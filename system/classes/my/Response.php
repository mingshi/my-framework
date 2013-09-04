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
        if (!$path) {
            $path = @MY::get_instance()->get_config();
        }
    }
    
}
