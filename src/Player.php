<?php

class Player{

  public $name;
  public $token;

  public function __construct($name, $token){
    $this->name = $name;
    $this->token = $token;
  }
  
}