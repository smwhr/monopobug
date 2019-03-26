<?php

require_once("Location.php");
require_once("Player.php");

class Game{

  private $locations = [];
  private $players = [];
  private $positions = [];

  public function __construct(){
    $cases = [
      ["name" => "Départ", "color" => "no", "special" => "start"],
      ["name" => "Boulevard de Belleville", "color" => "pink", "price" => 6],
      ["name" => "Caisse de Communauté", "color" => "no", "special" => "community"],
      ["name" => "Rue Lecourbe", "color" => "pink", "price" => 6],
      ["name" => "Impots sur le revenue", "color" => "no", "special" => "revenue_tax"],
      ["name" => "Gare Montparnasse", "color" => "black", "price" => 20],
      ["name" => "Rue de Vaugirard", "color" => "lightblue", "price" => 10],
      ["name" => "Chance", "color" => "no", "special" => "luck"],
      ["name" => "Rue de Courcelles", "color" => "lightblue", "price" => 10],
      ["name" => "Avenue de la République", "color" => "lightblue", "price" => 12],
      ["name" => "Prison", "color" => "no", "special" => "jail"],
      ["name" => "Boulevard de la Villette", "color" => "violet", "price" => 14],
      ["name" => "Electricité", "color" => "white", "price" => 15],
      ["name" => "Avenue de Neuilly", "color" => "violet", "price" => 14],
      ["name" => "Rue de Paradis", "color" => "violet", "price" => 16],
      ["name" => "Gare de Lyon", "color" => "black", "price" => 20],
      ["name" => "Avenue Mozart", "color" => "orange", "price" => 18],
      ["name" => "Caisse de Communauté", "color" => "no", "special" => "community"],
      ["name" => "Boulevard Saint-Michel", "color" => "orange", "price" => 18],
      ["name" => "Place Pigalle", "color" => "orange", "price" => 20],
      ["name" => "Parc Gratuit", "color" => "no", "special" => "park"],
      ["name" => "Avenue Matignon", "color" => "red", "price" => 22],
      ["name" => "Chance", "color" => "no", "special" => "luck"],
      ["name" => "Boulevard Malsherbe", "color" => "red", "price" => 22],
      ["name" => "Avenue Henri-Martin", "color" => "red", "price" => 24],
      ["name" => "Gare du Nord", "color" => "black", "price" => 20],
      ["name" => "Faubourg Saint-Honoré", "color" => "yellow", "price" => 26],
      ["name" => "Place de la Bourse", "color" => "yellow", "price" => 26],
      ["name" => "Compagnie des Eaux", "color" => "white", "price" => 15],
      ["name" => "Rue La Fayette", "color" => "yellow", "price" => 28],
      ["name" => "Allez en Prison", "color" => "no", "special" => "go_to_jail"],
      ["name" => "Avenue de Breteuil", "color" => "green", "price" => 30],
      ["name" => "Avenue Foch", "color" => "green", "price" => 30],
      ["name" => "Caisse de Communauté", "color" => "no", "special" => "community"],
      ["name" => "Boulevard des Capucines", "color" => "green", "price" => 32],
      ["name" => "Gare Saint-Lazare", "color" => "black", "price" => 20],
      ["name" => "Chance", "color" => "no", "special" => "luck"],
      ["name" => "Avenue des Champs-Elysées", "color" => "navy", "price" => 35],
      ["name" => "Luxe", "color" => "no", "special" => "lux_tax"],
      ["name" => "Rue de la Paix", "color" => "navy", "price" => 40],
    ];

    foreach($cases as $case){
      $this->locations[] = new Location(
          $case["name"],
          $case["color"],
          $case["price"] ?? false,
          //isset($case["price"]) ? $case["price"] : false
          $case["special"] ?? null
      );
    }
  }

  public function addPlayer(Player $player){
    $this->players[] = $player;
    $this->positions[$player->token] = 0;
  }

  public function getPlayer(){
    return reset($this->players);
  }

  public function move(Player $player, $moves){
    $this->positions[$player->token] = 
        (   $this->positions[$player->token] 
          + $moves)
        % count($this->locations)
        ;
  }

  public function getLocationOf(Player $player){
    $pos = $this->positions[$player->token];
    return $this->locations[$pos];
  }

  public function save(){
    return [
      "players" => $this->players,
      "positions" => $this->positions
    ];
  }

  public function load($saved_game){
    $this->players = $saved_game["players"];
    $this->positions = $saved_game["positions"];
  }
}