<?php

Class Tecnologia {

  private $id;
  private $idProprietario;
  private $login;
  private $senha;
  private $nome;
  private $descricao;
  private $tipoEquipamento;

  public function getId(){
		return $this->id;
	}

	public function setId($id){
		$this->id = $id;
	}

	public function getIdProprietario(){
		return $this->idProprietario;
	}

	public function setIdProprietario($idProprietario){
		$this->idProprietario = $idProprietario;
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

	public function getNome(){
		return $this->nome;
	}

	public function setNome($nome){
		$this->nome = $nome;
	}

	public function getDescricao(){
		return $this->descricao;
	}

	public function setDescricao($descricao){
		$this->descricao = $descricao;
	}

	public function getTipoEquipamento(){
		return $this->tipoEquipamento;
	}

	public function setTipoEquipamento($tipoEquipamento){
		$this->tipoEquipamento = $tipoEquipamento;
	}

}
