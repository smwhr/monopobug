<?php include("../views/head.php"); ?>

<?php echo $player->name;?>: 
<?php  echo $initialPosition ?>

<br> 


<?php echo $player->name;?> fait <?php echo $result;?>: 
<?php  echo $updatedPosition ?>


<form method="post" action="/?controller=play&action=new_player">
  <input type="text" name="player">
  <button type="submit">Ajouter</button>
</form>

<?php include("../views/foot.php"); ?>