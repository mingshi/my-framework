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
        if (!$this->dispatch()) {
            echo "1111";
        }
    }

    protected function dispatch() {
        my_require_class($this->router_class); 
        $router = new $this->router_class();
        $class = $router->mapping();
        $controller = $this->get_controller($class); 

        var_dump($controller);exit;
    }

    public function get_controller($class) {
        if (!$class) {
            return false;
        }
        if (isset($this->controllers[$class])) {
            return $this->controllers[$class];
        }
        $controller = $this->load_controller($class);
        $this->controllers[$class] = $controller;
        return $controller;
    }

    /**
     * @param string $class
     * @return APF_Controller
     */
    public function load_controller($class) {
        my_require_controller($class);
        $class= $class."Controller";
        return new $class();
    }

    private $controllers = array(); 
    
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

    public function get_request() {
        return $this->request;
    }
    
    public function get_response() {
        return $this->response;
    }

    public $config = array();
    private $router_class = "MY_Router";
    private $request_class = "MY_Request";
    private $response_class = "MY_Response";
}
