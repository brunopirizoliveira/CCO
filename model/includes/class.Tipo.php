<?php

Class Tipo {
	
	private $idTip;
	private $descricao;

	public function getIdTip(){
		return $this->idTip;
	}

	public function setIdTip($idTip){
		$this->idTip = $idTip;
	}

	public function getDescricao(){
		return $this->descricao;
	}

	public function setDescricao($descricao){
		$this->descricao = $descricao;
	}

}