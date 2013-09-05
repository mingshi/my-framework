<?php
/**
  * process http request
  * get params contain $_GET & $_POST
  */

class MY_Request {
    public function __construct() {
        $this->parameters_loader = $this;
    }

    public function __destruct() {
    }

    /**
      * 取得http请求的参数，缺省包括get和post
      * 不包括 cookie
      */
    public function get_parameters() {
        if (!isset($this->parameters)) {
            $this->parameters = $this->parameters_loader->load_parameters();
        }

        return $this->parameters;
    }

    public function get_parameter($name) {
        if (!isset($this->parameters)) {
            $this->parameters = $this->parameters_loader->load_parameters();
        }

        if (isset($this->parameters[$name])) {
            return $this->parameters[$name];
        } else {
            return NULL;
        }
    }

    public function load_parameters() {
        return array_merge($_GET, $_POST);
    }

    /**
      * url router 类会在mapping匹配之后进行设置
      */
    public function set_router_matches($matches) {
        $this->router_matches = $matches;
    }
    
    /**
      * 得到URL Router匹配之后的结果
      */

    public function get_router_matches() {
        return $this->router_matches;
    }


    private $router_matches = array();
    protected $parameters_loader;
    protected $parameters;
}
