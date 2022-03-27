<?php
  spl_autoload_register(
    function($class_name) {
        $dirs = array(
            'controllers/', 
            'models/', 
            'system/',
            'public/',   
        );

        foreach( $dirs as $dir ) {
            if (file_exists($dir.'/'.$class_name.'.php')) {
                include_once($dir.'/'.$class_name.'.php');
                return;
            }
        }
      });
 ?>
