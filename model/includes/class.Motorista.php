<?php

Class Motorista {

  private $idMotorista;
  private $idChave;
  private $idChip;
  private $nome;
  private $rg;
  private $cpf;
  private $email;
  private $filial;
  private $chapa;
  private $agregado;
  private $contratado;
  private $contratoAssinado;
  private $numCartao;

  public function getIdMotorista(){
		return $this->idMotorista;
	}

	public function setIdMotorista($idMotorista){
		$this->idMotorista = $idMotorista;
	}

	public function getIdChave(){
		return $this->idChave;
	}

	public function setIdChave($idChave){
		$this->idChave = $idChave;
	}

	public function getIdChip(){
		return $this->idChip;
	}

	public function setIdChip($idChip){
		$this->idChip = $idChip;
	}

	public function getNome(){
		return $this->nome;
	}

	public function setNome($nome){
		$this->nome = $nome;
	}

	public function getRg(){
		return $this->rg;
	}

	public function setRg($rg){
		$this->rg = $rg;
	}

	public function getCpf(){
		return $this->cpf;
	}

	public function setCpf($cpf){
		$this->cpf = $cpf;
	}

	public function getEmail(){
		return $this->email;
	}

	public function setEmail($email){
		$this->email = $email;
	}

	public function getFilial(){
		return $this->filial;
	}

	public function setFilial($filial){
		$this->filial = $filial;
	}

	public function getChapa(){
		return $this->chapa;
	}

	public function setChapa($chapa){
		$this->chapa = $chapa;
	}

	public function getAgregado(){
		return $this->agregado;
	}

	public function setAgregado($agregado){
		$this->agregado = $agregado;
	}

	public function getContratado(){
		return $this->contratado;
	}

	public function setContratado($contratado){
		$this->contratado = $contratado;
	}

	public function getContratoAssinado(){
		return $this->contratoAssinado;
	}

	public function setContratoAssinado($contratoAssinado){
		$this->contratoAssinado = $contratoAssinado;
	}

	public function getNumCartao(){
		return $this->numCartao;
	}

	public function setNumCartao($numCartao){
		$this->numCartao = $numCartao;
	}  

}
