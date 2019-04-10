<?php
require_once("../src/autoload.php");

session_start();

$controller_query = $_GET["controller"] ?? "index";
$action = $_GET["action"] ?? "home";

$controllerName = 
              "\Controllers\\".
              ucfirst($controller_query)."Controller";

$db = new \Services\DBConnect(
              "mysql:dbname=monopoly;host=127.0.0.1",
              "monopoly",
              "monopoly21"
            );
$conn = $db->getConnexion();

$controller = new $controllerName($conn);

$controller->$action();