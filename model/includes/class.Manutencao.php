<?php

Class Manutencao  {
	
	private $idManut;
	private $idFrota;
	private $idTecnologiaKit;
	private $dataAbertura;
	private $numeroOS;
	private $statusOS;
	private $dataAberturaOS;
	private $dataFimOS;
	private $dataAgendamento;
	private $localAtendimento;


	public function getIdManut(){
		return $this->idManut;
	}

	public function setIdManut($idManut){
		$this->idManut = $idManut;
	}

	public function getIdFrota(){
		return $this->idFrota;
	}

	public function setIdFrota($idFrota){
		$this->idFrota = $idFrota;
	}

	public function getIdTecnologiaKit(){
		return $this->idTecnologiaKit;
	}

	public function setIdTecnologiaKit($idTecnologiaKit){
		$this->idTecnologiaKit = $idTecnologiaKit;
	}

	public function getDataAbertura(){
		return $this->dataAbertura;
	}

	public function setDataAbertura($dataAbertura){
		$this->dataAbertura = $dataAbertura;
	}

	public function getNumeroOS(){
		return $this->numeroOS;
	}

	public function setNumeroOS($numeroOS){
		$this->numeroOS = $numeroOS;
	}

	public function getStatusOS(){
		return $this->statusOS;
	}

	public function setStatusOS($statusOS){
		$this->statusOS = $statusOS;
	}

	public function getDataAberturaOS(){
		return $this->dataAberturaOS;
	}

	public function setDataAberturaOS($dataAberturaOS){
		$this->dataAberturaOS = $dataAberturaOS;
	}

	public function getDataFimOS(){
		return $this->dataFimOS;
	}

	public function setDataFimOS($dataFimOS){
		$this->dataFimOS = $dataFimOS;
	}

	public function getDataAgendamento(){
		return $this->dataAgendamento;
	}

	public function setDataAgendamento($dataAgendamento){
		$this->dataAgendamento = $dataAgendamento;
	}

	public function getLocalAtendimento(){
		return $this->localAtendimento;
	}

	public function setLocalAtendimento($localAtendimento){
		$this->localAtendimento = $localAtendimento;
	}

}