<?php include("../views/head.php"); ?>
<h1>Monopoly !</h1>

<h2>Liste des parties en cours</h2>
<ul>
  <?php foreach($games as $game):?>
    <li>
      <a href="/?controller=index&action=game&id=<?php echo $game["id"]?>">
        <?php echo $game["name"]?>
      </a>
    </li>
  <?php endforeach; ?>
</ul>

<h2>Nouelle partie</h2>
<form method="post" action="/?controller=play&action=new_game">
  <input type="text" name="game_name">
  <button type="submit">Créer</button>
</form>

<?php include("../views/foot.php"); ?>