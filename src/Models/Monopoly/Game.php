<?php
namespace Models\Monopoly;

use \Models\Generic\Player;

class Game{

  private $id;
  private $name;
  private $locations = [];
  private $players = [];
  private $positions = [];
  private $status = "initial";

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

  public static function fetchAll($conn){
    $sql = "SELECT * FROM game";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $games = $stmt->fetchAll();
    return $games;
  }

  public static function loadFromDB($conn, $gameId){
    $sql = "SELECT * FROM game WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$gameId]);

    // recupere les infos principales
    $saved_game = $stmt->fetch();

    // recupère les jours
    $sql = "SELECT * FROM player";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $saved_game["players"] = array_map(function($row){
      return new Player($row["name"], $row["token"]);
    }, $stmt->fetchAll());

    // on charge les données dans notre partie
    $board = new Game();
    $board->load($saved_game);
    return $board;
  }

  public function addPlayer(Player $player){
    if($this->status != "initial")
      throw new Exception("Game has already started !");

    if(isset($this->players[$player->token]))
      throw new Exception("Token already in use !");

    $this->players[$player->token] = $player;
    $this->positions[$player->token] = 0;
  }

  public function getPlayers(){
    return $this->players;
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

  public function start(){
    $this->status = "started";
  }
  public function reinit(){
    $this->status = "initial";
    $this->players = [];
    $this->positions = [];
  }
  public function getStatus(){
    return $this->status;
  }
  public function getName(){
    return $this->name;
  }
  public function getId(){
    return $this->id;
  }

  public function save(){
    return [
      "players" => $this->players,
      "positions" => $this->positions
    ];
  }

  public function load($saved_game){
    $this->players = $saved_game["players"];
    $this->id    = $saved_game["id"];
    $this->name      = $saved_game["name"];
    $this->positions = json_decode($saved_game["positions"], true);
    $this->status    = $saved_game["status"];
  }
}