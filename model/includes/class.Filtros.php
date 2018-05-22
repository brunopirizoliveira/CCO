<?php

class Filtros {
	
	private $filial;
	private $operacao;
	private $tpFrota;
	
	public function getFilial(){
		return $this->filial;
	}
	
	public function setFilial($filial){
		$this->filial = $filial;
	}
	
	public function getOperacao(){
		return $this->operacao;
	}
	
	public function setOperacao($operacao){
		$this->operacao = $operacao;
	}
	
	public function getTpFrota(){
		return $this->tpFrota;
	}
	
	public function setTpFrota($tpFrota){
		$this->tpFrota = $tpFrota;
	}
	
}