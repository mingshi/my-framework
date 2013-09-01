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
        var_dump('This in my first own framework');
    }
}
