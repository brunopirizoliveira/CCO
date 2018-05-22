<?php

Class Frota {

  private $idFrota;
  private $idProprietario;
  private $idMotorista;
  private $marca;
  private $situacao;
  private $tpFrota;
  private $filial;
  private $placa;
  private $prefixo;
  private $operacao;
  private $empresa;
  private $filia;
  private $garagem;
  private $idtecnologia;
  private $idtecnologiaoriginal;
  private $medicao;
  private $fornecedor;
  private $equipamento;
  private $numequipamento;
  private $instalacao;


  	public function getIdFrota(){
		return $this->idFrota;
	}

	public function setIdFrota($idFrota){
		$this->idFrota = $idFrota;
	}

	public function getIdProprietario(){
		return $this->idProprietario;
	}

	public function setIdProprietario($idProprietario){
		$this->idProprietario = $idProprietario;
	}

	public function getIdMotorista(){
		return $this->idMotorista;
	}

	public function setIdMotorista($idMotorista){
		$this->idMotorista = $idMotorista;
	}

	public function getMarca(){
		return $this->marca;
	}

	public function setMarca($marca){
		$this->marca = $marca;
	}

	public function getSituacao(){
		return $this->situacao;
	}

	public function setSituacao($situacao){
		$this->situacao = $situacao;
	}

	public function getTpFrota(){
		return $this->tpFrota;
	}

	public function setTpFrota($tpFrota){
		$this->tpFrota = $tpFrota;
	}

	public function getFilial(){
		return $this->filial;
	}

	public function setFilial($filial){
		$this->filial = $filial;
	}

	public function getPlaca(){
		return $this->placa;
	}

	public function setPlaca($placa){
		$this->placa = $placa;
	}

	public function getPrefixo(){
		return $this->prefixo;
	}

	public function setPrefixo($prefixo){
		$this->prefixo = $prefixo;
	}

	public function getOperacao(){
		return $this->operacao;
	}

	public function setOperacao($operacao){
		$this->operacao = $operacao;
	}

	public function getEmpresa(){
		return $this->empresa;
	}

	public function setEmpresa($empresa){
		$this->empresa = $empresa;
	}

	public function getFilia(){
		return $this->filia;
	}

	public function setFilia($filia){
		$this->filia = $filia;
	}

	public function getGaragem(){
		return $this->garagem;
	}

	public function setGaragem($garagem){
		$this->garagem = $garagem;
	}
	
	public function getIdTecnologia(){
		return $this->idtecnologia;
	}
	
	public function setIdTecnologia($idtecnologia){
		$this->idtecnologia = $idtecnologia;
	}
	
	public function getIdTecnologiaOriginal(){
		return $this->idtecnologiaoriginal;
	}
	
	public function setIdTecnologiaOriginal($idtecnologiaoriginal){
		$this->idtecnologiaoriginal = $idtecnologiaoriginal;
	}
	
	public function getMedicao(){
		return $this->medicao;
	}
	
	public function setMedicao($medicao){
		$this->medicao = $medicao;
	}
	
	public function getFornecedor(){
		return $this->fornecedor;
	}
	
	public function setFornecedor($fornecedor){
		$this->fornecedor = $fornecedor;
	}
	
	public function getEquipamento(){
		return $this->equipamento;
	}
	
	public function setEquipamento($equipamento){
		$this->equipamento = $equipamento;
	}
	
	public function getNumEquipamento(){
		return $this->numequipamento;
	}
	
	public function setNumEquipamento($numequipamento){
		$this->numequipamento = $numequipamento;
	}
	
	public function getInstalacao(){
		return $this->instalacao;
	}
	
	public function setInstalacao($instalacao){
		$this->instalacao = $instalacao;
	}



}
