<?php
error_reporting(E_ALL);
$db_host = 'localhost'; // 127.0.0.1
$db_user = 'root';
$db_password = '';
$db_name = 'college_ms';
$salt = "d69!d0#c63(37f@cyd&s7#%d7s^s7";
//$db_port = 3306;
$connection = @mysqli_connect($db_host, $db_user, $db_password, $db_name);
if(mysqli_connect_error()) {
  echo 'There is some technical issue. Please report website administrator.';
//  exit;
  die();
}
mysqli_select_db($connection, $db_name);
session_start();

/*spl_autoload_register(function($class_name) {
  $filename = $class_name.'.php';
  if(file_exists('models'.DIRECTORY_SEPARATOR.$filename)) {
    require 'models'.DIRECTORY_SEPARATOR.$filename;
  } else if('components'.DIRECTORY_SEPARATOR.$filename) {
    require 'components'.DIRECTORY_SEPARATOR.$filename;
  }
});*/
//require_once BASE_PATH.DIRECTORY_SEPARATOR.'vendor'.DIRECTORY_SEPARATOR.'PhpRbac'.DIRECTORY_SEPARATOR.'autoload.php';
function dd($object) {
    echo '<pre>';
    print_r($object);
    echo '</pre>';
    exit;
    
}

function redirect($url) {
  header("Location:{$url}");
}

function cmsExceptionHandler($exception) {
  echo $exception->getMessage();
}

set_exception_handler('cmsExceptionHandler');