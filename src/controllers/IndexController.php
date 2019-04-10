<?php

namespace Controllers;
use \Models\Generic\Dice;

use \Models\Monopoly\Game as Monopoly;
use \Models\LaBonnePaie\Game as LBP;


class IndexController{

  public function home(){
      $db = new \Services\DBConnect(
              "mysql:dbname=monopoly;host=127.0.0.1",
              "monopoly",
              "monopoly21"
            );
      $sql = "SELECT * FROM game";
      $conn = $db->getConnexion();
      $stmt = $conn->prepare($sql);
      $stmt->execute();
      $games = $stmt->fetchAll();

      include("../views/index/gamelist.php");
  }

  public function game(){
    $gameId = $_GET["id"];

    $db = new \Services\DBConnect(
              "mysql:dbname=monopoly;host=127.0.0.1",
              "monopoly",
              "monopoly21"
            );
    $sql = "SELECT * FROM game WHERE id = ?";
    $conn = $db->getConnexion();
    $stmt = $conn->prepare($sql);
    $stmt->execute([$gameId]);

    $game = $stmt->fetch();
    $board = new Monopoly();

    $dice = new Dice(6);

    if($board->getStatus() == "initial"){
      include("../views/index/initial.php");
    }else{
      include("../views/index/game.php");
    }
  }


  function home_test(){
    // cree un board
    

    // cree ou récupère le joueur
    if(isset($_SESSION["saved_game"])){
      $board->load($_SESSION["saved_game"]);
      $player = $board->getPlayer();
    }else{
      $player = new Player("Bob", "hat");
      $board->addPlayer($player);
    }

    $initialPosition = $board->getLocationOf($player);

    //create dice
    $d1 = new Dice(6);
    $d2 = new Dice(6);
    // roll them
    $result = $d1->roll() + $d2->roll();

    // move player
    $board->move($player, $result);

    $updatedPosition = $board->getLocationOf($player);

    // sauvegarde de l'état
    $_SESSION["saved_game"] = $board->save();

    include("../views/index/home.php");
  }  

}

