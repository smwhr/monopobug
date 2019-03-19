<?php

class Dice{

  private $faces = null;

  public function __construct($faces){
    $this->faces = $faces;
  }

  public function roll(){
    return mt_rand(1, $this->faces);
  }
  
}