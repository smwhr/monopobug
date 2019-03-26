<?php
require_once("../models/Dice.php");
require_once("../models/Game.php");
require_once("../models/Player.php");
session_start();

$controller_query = $_GET["controller"] ?? "index";
$action = $_GET["action"] ?? "home";

$controllerName = ucfirst($controller_query)."Controller";

require("../controllers/".$controllerName.".php");
$controller = new $controllerName;

$controller->$action();