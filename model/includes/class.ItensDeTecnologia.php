<?php

Class ItensDeTecnologia extends Tecnologia{
	
	private $idItem;
	private $descricao;
	private $idSubgrupo;

	public function getIdItem(){
		return $this->idItem;
	}

	public function setIdItem($idItem){
		$this->idItem = $idItem;
	}

	public function getDescricao(){
		return $this->descricao;
	}

	public function setDescricao($descricao){
		$this->descricao = $descricao;
	}

	public function getIdSubgrupo(){
		return $this->idSubgrupo;
	}

	public function setIdSubgrupo($idSubgrupo){
		$this->idSubgrupo = $idSubgrupo;
	}

}