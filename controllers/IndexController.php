<?php
class IndexController{

  function home(){
    // cree un board
    $board = new Game();

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

