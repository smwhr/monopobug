<?php include("../views/head.php"); ?>
<h1>Monopoly !</h1>

<?php if(count($board->getPlayers())):?>
  <h3>Liste des joueurs</h3>
  <ul>
    <?php foreach($board->getPlayers() as $player):?>
      <li>
        <?php echo $player->name; ?>
        (<?php echo $player->token; ?>)
        
      </li>
    <?php endforeach;?>
  </ul>
<?php else:?>
  <em>Pas encore de joueurs inscrits</em>
<?php endif;?>

<h3>Ajouter un joueur</h3>

<form method="post" action="/?controller=play&action=new_player">
  <input type="text" name="player_name">
  <select name="player_token">
    <option value="thimble">Dé à coudre</option>
    <option value="hat">Chapeau</option>
    <option value="dog">Chien</option>
    <option value="pawn">Pion</option>
    <option value="car">Voiture</option>
  </select>
  <button type="submit">Ajouter</button>

</form>

<?php include("../views/foot.php"); ?>