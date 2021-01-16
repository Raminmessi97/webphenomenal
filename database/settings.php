<?php

$host =  $_ENV['DB_HOST'];
$database = $_ENV['DB_DATABASE'];
$username = $_ENV['DB_USERNAME'];
$password = $_ENV['DB_PASSWORD'];

return [
 	'host'=>$host,
 	'database'=>$database,
 	'user'=>$username,
 	'password'=>$password,
];