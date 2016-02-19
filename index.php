<?php

try {
    define('DS', '/');
    define('CLASSES', 'inc');
    define('LIBRARY', 'lib');
    define('CONFIG', 'config');
    define('APPLICATION_ENV', 'dev');
    define('ROOT', dirname(__FILE__));

    if (APPLICATION_ENV == 'dev') {
        error_reporting(E_ALL | E_STRICT);    // E_ERROR | E_CORE_ERROR | E_COMPILE_ERROR   E_ALL | E_STRICT
        ini_set('display_errors', 'on');
    } else {
        error_reporting(0);
        ini_set('display_errors', 'off');
    }
    require_once ROOT.DS.CLASSES.DS.'api.php';
    if ($security->handleControl()) {
        if (in_array($security->handleCommand(), $actions) && $actions[$security->handleCommand()]) {
            $api->$actions[$security->handleCommand()]();
        }
        //  else {
        //     header('HTTP/1.0 400 Bad Request');
        // }
    }
} catch (Exception $e) {
    if (APPLICATION_ENV == 'dev') {
        var_dump($e);
    } else {
        header('HTTP/1.0 500 Server Error');
    }
}
