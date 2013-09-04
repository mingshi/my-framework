<?php
/**
  * system function 
  * load in index
  */

function my_require_class($class, $prefix="classes") {
    if ($prefix == "classes" && class_exists($class)) {
        return TRUE;
    }

    $file = my_classname_2_filename($class);
    
    if (!require_once($prefix."/".$file.".php")) {
        return FALSE;
    }
    
    return TRUE;
}

function my_classname_2_filename($class) {
    $paths = explode("_", $class);
    $count = count($paths) - 1;

    $path = "";

    for ($i=0; $i < $count; $i++) {
        $path .= strtolower($paths[$i]) . "/";
    }
    $class = $paths[$count];
    return "$path$class";
}

function redirect_to($str) {
    $server = $_SERVER['HTTP_HOST'];
    header('Location: '.$server.$str);
}

function getFile($dir) {
  $fileArray[]=NULL;
  if (false != ($handle = opendir ( $dir ))) {
      $i=0;
      while ( false !== ($file = readdir ( $handle )) ) {
          //去掉"“.”、“..”以及带“.xxx”后缀的文件
          if ($file != "." && $file != ".."&&strpos($file,".")) {
              $fileArray[$i] = $dir.$file;
              if($i == 100){
                  break;
              }
              $i++;
          }
      }
      //关闭句柄
      closedir ( $handle );
  }
  return $fileArray;
}
