<?php
/**
  * process frame router
  */
class MY_Router {
    const DEFAULT_REGEX_FUNCTION  = 'ereg';
    const CONFIG_N_REGEX_FUNCTION = 'regex_function';
    const CONFIG_F_ROUTE          = 'router';
    const HTTP404_CONTROLLER = "404";

    public function mapping() {
        $config = $GLOBALS['config'];
        $routers = $config[self::CONFIG_F_ROUTE];
       
        $regex_function = isset($config[self::CONFIG_N_REGEX_FUNCTION]) ? $config[self::CONFIG_N_REGEX_FUNCTION] : self::DEFAULT_REGEX_FUNCTION;

        if (!function_exists($regex_function)) {
            $regex_function = self::DEFAULT_REGEX_FUNCTION;
        }
        
        if (BASE_URI != '' && strpos($_SERVER['REQUEST_URI'], BASE_URI) === 0) {
            $uri = substr($_SERVER['REQUEST_URI'], strlen(BASE_URI));
        } else {
            $uri = $_SERVER['REQUEST_URI'];
        }
        $pos = strpos($uri, '?');
        if ($pos) {
            $uri = substr($uri, 0, $pos);
        }
        if (empty($uri)) {
            $uri = '/';
        }

        $matches = array();
        foreach ($routers as $class => $mapping) {
            foreach ($mapping as $pattern) {
                if (@$regex_function($pattern, $uri, $matches)) {
                    MY::get_instance()->get_request()->set_router_matches($matches);
                    return $class;
                }
            }
        }
        
        $class = $this->auto_mapping($uri);
        if ($class) {
            return $class;
        }

        $class = $routers['404'];
        if ($class) {
            return $class;
        }
        
        MY::get_instance()->get_response()->set_header("HTTP/1.1", "404 Not Found", "404");
        return FALSE;
    }

    private function auto_mapping($uri) {
        $class_name = $this->uri2Controller($uri);
        my_require_controller($class_name);
        if (class_exists($class_name . 'Controller')) {
            return $class_name;
        }

        return FALSE;
    }

    protected function uri2Controller($uri) {
        $matches = explode('/', $uri);
        $class = FALSE;
        foreach ($matches as $item) {
            if (trim($item) != "") {
               $class .= ucfirst($item)."_";
            }
        }

        $class = trim($class, "_");
        return $class;
    }
}
