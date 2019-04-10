<?php 
namespace Controllers;

class GameController extends BaseController{

  function new(){
    $name = $_POST["game_name"];

    $sql = "INSERT INTO game (name, positions, status) 
              VALUES (?, ?, ?)";

    $stmt = $this->conn->prepare($sql);
    $stmt->execute([$name, "{}", "initial"]);

    header("Location: /"); exit;
  }

  function new_player(){
    $name = $_POST["player_name"];
    $token = $_POST["player_token"];

    $gameId = $_GET["game_id"];

    //TODO vérifier des trucs

    $sql = "INSERT INTO player (name, token) 
              VALUES (?, ?)";

    $stmt = $this->conn->prepare($sql);
    $stmt->execute([$name, $token]);

    header("Location: /?controller=index&action=game&id=".$gameId); exit;

  }

}