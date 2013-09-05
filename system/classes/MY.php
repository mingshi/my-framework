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

    /**
      * FrameWork request
      */
    private $request;

    /**
      * FrameWork response
      */
    private $response;

    public function run() {
        my_require_class($this->request_class);
        my_require_class($this->response_class);
    
        $this->load_config();
        $this->request = new $this->request_class();
        $this->response = new $this->response_class();

        $GLOBALS['config'] = $this->config;
        $this->response->set_cookie('username', '1');
        if (!$this->dispatch()) {
            echo "1111";
        }
    }

    protected function dispatch() {
        return FALSE;
    }

    public function load_config() {
        global $G_CONF_PATH;
        foreach ($G_CONF_PATH as $path) {
            $files = getFile($path);
            foreach ($files as $file) {
                require_once "$file";
                $this->config = array_merge($this->config, $config);
            }
        }
    }

    public $config = array();
    private $router_class = "MY_Router";
    private $request_class = "MY_Request";
    private $response_class = "MY_Response";
}
