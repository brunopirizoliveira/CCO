<?php

Class Medicoes {
	
	private $idMed;
	private $descricao;

	public function getIdMed(){
		return $this->idMed;
	}

	public function setIdMed($idMed){
		$this->idMed = $idMed;
	}

	public function getDescricao(){
		return $this->descricao;
	}

	public function setDescricao($descricao){
		$this->descricao = $descricao;
	}
		
}