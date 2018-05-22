<?php

Class Proprietario {

  private $idProprietario;
  private $nome;
  private $rg;
  private $cpf;
  private $fone1;
  private $fone2;
  private $contato;
  private $email;
  private $login;
  private $senha;

  public function getIdProprietario(){
		return $this->idProprietario;
	}

	public function setIdProprietario($idProprietario){
		$this->idProprietario = $idProprietario;
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

	public function getFone1(){
		return $this->fone1;
	}

	public function setFone1($fone1){
		$this->fone1 = $fone1;
	}

	public function getFone2(){
		return $this->fone2;
	}

	public function setFone2($fone2){
		$this->fone2 = $fone2;
	}

	public function getContato(){
		return $this->contato;
	}

	public function setContato($contato){
		$this->contato = $contato;
	}

	public function getEmail(){
		return $this->email;
	}

	public function setEmail($email){
		$this->email = $email;
	}

	public function getLogin(){
		return $this->login;
	}

	public function setLogin($login){
		$this->login = $login;
	}

	public function getSenha(){
		return $this->senha;
	}

	public function setSenha($senha){
		$this->senha = $senha;
	}

}
