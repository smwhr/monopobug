<?php

class Location{
  private $name;
  private $price = false;
  private $color;
  private $special = null;

  public function __construct($name,  $color, $price = 0, $special = null){
    $this->name = $name;
    $this->color = $color;
    $this->price = $price;
    $this->special = $special;
  }

  public function __toString(){
    return "<span style='color:".$this->color."'>"
          . $this->name
          . "</span>";
  }

  
}