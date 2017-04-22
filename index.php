<?php
define('BASE_PATH', __DIR__);
require 'config/config.php';
spl_autoload_register(function($class_name) {
    $app_path = 'app'.DIRECTORY_SEPARATOR;
    $filename = $class_name . '.php';
    if (file_exists($app_path.'controllers' . DIRECTORY_SEPARATOR . $filename)) {
        require $app_path.'controllers' . DIRECTORY_SEPARATOR . $filename;
    } else if ($app_path.'models' . DIRECTORY_SEPARATOR . $filename) {
        require $app_path.'models' . DIRECTORY_SEPARATOR . $filename;
    } else if ($app_path.'views' . DIRECTORY_SEPARATOR . $filename) {
        require $app_path.'views' . DIRECTORY_SEPARATOR . $filename;
    }
});
if (isset($_GET['route'])) {
    $route = explode('/', $_GET['route']);
    $controller_file = ucwords($route[0]).'Controller';
    $action = 'actionIndex';
    if(isset($route[1])) {
        $action = 'action'.ucwords($route[1]);
    }
    $controller = new $controller_file;
    $controller->view_path = $route[0]; // user
    $controller->{$action}();
//    print_r($controller);
//    print_r($route);
}
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

