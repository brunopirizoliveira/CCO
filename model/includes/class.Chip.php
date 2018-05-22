<?php

Class Chip {

  private $idChip;
  private $numero;
  private $imei;
  private $operadora;

  public function getIdChip(){
		return $this->idChip;
	}

	public function setIdChip($idChip){
		$this->idChip = $idChip;
	}

	public function getNumero(){
		return $this->numero;
	}

	public function setNumero($numero){
		$this->numero = $numero;
	}

	public function getImei(){
		return $this->imei;
	}

	public function setImei($imei){
		$this->imei = $imei;
	}

	public function getOperadora(){
		return $this->operadora;
	}

	public function setOperadora($operadora){
		$this->operadora = $operadora;
	}

}
