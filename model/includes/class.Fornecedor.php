<?php

Class Fornecedor {
	
	private $idFornecedor;
	private $descricao;

	public function getIdFornecedor(){
		return $this->idFornecedor;
	}

	public function setIdFornecedor($idFornecedor){
		$this->idFornecedor = $idFornecedor;
	}

	public function getDescricao(){
		return $this->descricao;
	}

	public function setDescricao($descricao){
		$this->descricao = $descricao;
	}
		
}