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
