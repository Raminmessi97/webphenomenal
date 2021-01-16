<?php

session_start();

require_once 'vendor/autoload.php';

use Dotenv\Dotenv;
use Router\MainRouting;

// 

// Вывод ошибок
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
// 

// Для .env

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

$route = trim($_SERVER['REQUEST_URI']);


// get full url
if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') 
    $url_main = "https"; 
else
    $url_main = "http"; 
  
$url_main .= "://"; 
   
$url_main .= $_SERVER['HTTP_HOST']."/"; 
  
$project_root = $_SERVER['DOCUMENT_ROOT']."/";

// Определяем константы


define("URL_MAIN",$url_main);   // http://localhost/php_projs/phenomenon

define("URL_ROUTE",$route);  // after url_main

define("PROJECT_ROOT",$project_root);

// 


MainRouting::all_routes();
