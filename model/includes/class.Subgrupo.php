<?php

Class Subgrupo {
	
	private $idSubgrupo;
	private $descricao;


	public function getIdSubgrupo(){
		return $this->idSubgrupo;
	}

	public function setIdSubgrupo($idSubgrupo){
		$this->idSubgrupo = $idSubgrupo;
	}

	public function getDescricao(){
		return $this->descricao;
	}

	public function setDescricao($descricao){
		$this->descricao = $descricao;
	}
	
}