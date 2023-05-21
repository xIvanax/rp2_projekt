<?php

/*
template od dz2 rp2 
*/
session_start();
if(isset($_GET["rt"])){
  $route = $_GET["rt"];
}
else{
  $route = "login/login";
}

$routeElements = explode('/', $route); // ["users", "search"]
$controllerName = $routeElements[0] . "controller"; // userController
if(count($routeElements) > 1){
  $action = $routeElements[1];
}
else{
  $action = "index";
}

require_once __DIR__ . "/controller/" . $controllerName . ".class.php";

$con = new $controllerName;
//echo $action;
$con->$action();
 ?>
