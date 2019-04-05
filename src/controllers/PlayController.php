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
}