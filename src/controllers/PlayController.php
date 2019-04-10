<?php

namespace Controllers;

class PlayController{

  private function getBoard(){
    $board = new \Models\Monopoly\Game();

    if(isset($_SESSION["saved_game"])){
      $board->load($_SESSION["saved_game"]);
    }

    return $board;
  }

  function new_player(){
    $board = $this->getBoard();
    $player = new \Models\Generic\Player(
      $_POST["player_name"],
      $_POST["player_token"]
    );

    $board->addPlayer($player);

    $_SESSION["saved_game"] = $board->save();

    header("Location: /"); exit;
  }

  function new_game(){
    $name = $_POST["game_name"];


    $db = new \Services\DBConnect(
              "mysql:dbname=monopoly;host=127.0.0.1",
              "monopoly",
              "monopoly21"
            );
    $conn = $db->getConnexion();
    $sql = "INSERT INTO game (name, positions, status) 
              VALUES (?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->execute([$name, "{}", "initial"]);

    header("Location: /"); exit;
  }
}