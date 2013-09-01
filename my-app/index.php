<?php
/**
  * 默认index在app目录下。
  * 部署的时候，index文件可以其他目录，一般建议放在单独的目录，index文件一般不会更改。
  * 配置文件目录可以也可以放在外面，app目录下的config目录可以放一些默认配置。
  */


if (!defined('E_DEPRECATED')) {
    define('E_DEPRECATED',0);
}
#error_reporting(E_ALL);
error_reporting(E_ALL&~E_NOTICE);
ini_set("display_errors", 1);
// 以html形式显示错误，配合xdebug超级给力
ini_set("html_errors", 1);

$request_uri = ($_SERVER['REQUEST_URI']);
if (preg_match('/^\/[^\/]+\/\d+\.\d+(\.[^\/]+)\/.*/', $request_uri, $matches)) {
    $version = substr($matches[1], 1);
    $_SERVER['REQUEST_URI'] = preg_replace('/(^\/[^\/]+\/\d+\.\d+)(\.[^\/]+)(\/.*)/', '\\1\\3', $request_uri);
}

define('APP_NAME', 'my-app');
define('APP_PATH', realpath(dirname(__FILE__)).'/');
define('SYS_PATH', APP_PATH."../system/");

$G_LOAD_PATH = array(
    APP_PATH,
    //可以配置多个load路径
);
$G_CONF_PATH = array(
    APP_PATH."config/",
    //可以添加多个config目录，写在后面的可以将前面的配置覆盖。便于不同环境的运行
);

require_once(SYS_PATH.'function.php');
my_require_class('MY');
MY::get_instance()->run();
