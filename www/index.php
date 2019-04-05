<?php
require_once("../src/autoload.php");

session_start();

$controller_query = $_GET["controller"] ?? "index";
$action = $_GET["action"] ?? "home";

$controllerName = ucfirst($controller_query)."Controller";

$controller = new $controllerName;

$controller->$action();