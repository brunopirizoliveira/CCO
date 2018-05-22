<?php

Class Chave {

  private $idChave;
  private $numChave;

  public function getIdChave(){
    return $this->idChave;
  }

  public function setIdChave($idChave){
    $this->idChave = $idChave;
  }

  public function getNumChave(){
    return $this->numChave;
  }

  public function setNumChave($numChave){
    $this->numChave = $numChave;
  }

}
