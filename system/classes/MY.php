<?php
/**
  * final system class
  */

final class MY {
    public static function &get_instance() {
        if (!self::$instance) {
            self::$instance = new MY();
        }
        return self::$instance;
    }

    private static $instance;

    public function run() {
        my_require_class($this->request_class);
        my_require_class($this->response_class);
        var_dump('hahah');
    }

    private $router_class = "MY_Router";
    private $request_class = "MY_Request";
    private $response_class = "MY_Response";
}
