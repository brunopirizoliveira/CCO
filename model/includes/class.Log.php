<?php

Class Log extends Usuario{
	
	private $idLog;
	private $dataLog;
	private $dataHoraLog;
	private $textoLog;
	private $ipAdress;

	public function getIdLog(){
		return $this->idLog;
	}

	public function setIdLog($idLog){
		$this->idLog = $idLog;
	}

	public function getDataLog(){
		return $this->dataLog;
	}

	public function setDataLog($dataLog){
		$this->dataLog = $dataLog;
	}

	public function getDataHoraLog(){
		return $this->dataHoraLog;
	}

	public function setDataHoraLog($dataHoraLog){
		$this->dataHoraLog = $dataHoraLog;
	}

	public function getTextoLog(){
		return $this->textoLog;
	}

	public function setTextoLog($textoLog){
		$this->textoLog = $textoLog;
	}

	public function getIpAdress(){
		return $this->ipAdress;
	}

	public function setIpAdress($ipAdress){
		$this->ipAdress = $ipAdress;
	}

}