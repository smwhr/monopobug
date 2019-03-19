<?php
  session_start();
  require_once("../src/Dice.php");
  require_once("../src/Game.php");
  require_once("../src/Player.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Monopoly !</title>
</head>
<body>

  <?php 
    $board = new Game();
  ?>
  <?php
  if(isset($_SESSION["saved_game"])){
    $board->load($_SESSION["saved_game"]);
  }else{
    $player = new Player("Bob", "hat");
    $board->addPlayer($player);
  }
  ?>

  <?php echo $player->name;?>: 
  <?php 
    echo $board->getLocationOf($player);
  ?>
<br>
  <?php
    $d1 = new Dice(6);
    $d2 = new Dice(6);
    $result = $d1->roll() + $d2->roll();
  ?>

  <?php
    $board->move($player, $result);
  ?>
  <?php echo $player->name;?> fait <?php echo $result;?>: 
  <?php 
    echo $board->getLocationOf($player);
  ?>

  <?php
    $_SESSION["saved_game"] = $board->save();
  ?>

</body>
</html>