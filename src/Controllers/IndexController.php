<?php

namespace Controllers;
use \Models\Generic\Dice;

use \Models\Monopoly\Game as Monopoly;
use \Models\LaBonnePaie\Game as LBP;


class IndexController extends BaseController{

  public function home(){

      $games = Monopoly::fetchAll($this->conn);

      include("../views/index/gamelist.php");
  }

  public function game(){
    $gameId = $_GET["id"];

    $board = Monopoly::loadFromDB($this->conn, $gameId);

    if($board->getStatus() == "initial"){
      include("../views/game/initial.php");
    }else{
      include("../views/index/game.php");
    }
  }

}

