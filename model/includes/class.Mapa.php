<?php

	class Mapa{
		private $stGlobus;
		private $frota;
		private $placa;
		private $operacao;
		private $filial;
		private $tipo;
		private $rastreador;
		private $numAntenaRas;
		private $numAntenaTel;
		private $telemetria;
		private $comunicacao;
		private $stRastreador;
		private $stManutRastreador;
		private $stTelemetria;
		private $stManutTelemetria;
		private $ambos;
		private $numAntenaAmb;
		private $comunicacaoAmb;
		private $temContrato;
		
		public function getStGlobus(){
			return $this->stGlobus;
		}
		
		public function setStGlobus($stGlobus){
			$this->stGlobus = $stGlobus;
		}
		
		public function getFrota(){
			return $this->frota;
		}
		
		public function setFrota($frota){
			$this->frota = $frota;
		}
		
		public function getPlaca(){
			return $this->placa;
		}
		
		public function setPlaca($placa){
			$this->placa = $placa;
		}
		
		public function getOperacao(){
			return $this->operacao;
		}
		
		public function setOperacao($operacao){
			$this->operacao = $operacao;
		}
		
		public function getFilial(){
			return $this->filial;
		}
		
		public function setFilial($filial){
			$this->filial = $filial;
		}
		
		public function getTipo(){
			return $this->tipo ;
		}
		
		public function setTipo($tipo){
			$this->tipo = $tipo;
		}
		
		public function getRastreador(){
			return $this->rastreador;
		}
		
		public function setRastreador($rastreador){
			$this->rastreador = $rastreador;
		}
		
		public function getNumAntenaRas(){
			return $this->numAntenaRas;
		}
		
		public function setNumAntenaRas($numAntenaRas){
			$this->numAntenaRas = $numAntenaRas;
		}

		public function getNumAntenaTel(){
			return $this->numAntenaTel;
		}
		
		public function setNumAntenaTel($numAntenaTel){
			$this->numAntenaTel = $numAntenaTel;
		}
		
		public function getTelemetria(){
			return $this->telemetria;
		}
		
		public function setTelemetria($telemetria){
			$this->telemetria = $telemetria;
		}
		
		public function getComunicacao(){
			return $this->comunicacao;
		}
		
		public function setComunicacao($comunicacao){
			$this->comunicacao = $comunicacao;
		}
		
		public function getStRastreador(){
			return $this->stRastreador;
		}
		
		public function setStRastreador($stRastreador){
			$this->stRastreador = $stRastreador;
		}

		public function getStManutRastreador(){
			return $this->stManutRastreador;
		}
		
		public function setStManutRastreador($stManutRastreador){
			$this->stManutRastreador = $stManutRastreador;
		}
		
		public function getStTelemetria(){
			return $this->stTelemetria;
		}
		
		public function setStTelemetria($stTelemetria){
			$this->stTelemetria = $stTelemetria;
		}
		
		public function getStManutTelemetria(){
			return $this->stManutTelemetria;
		}
		
		public function setStManutTelemetria($stManutTelemetria){
			$this->stManutTelemetria = $stManutTelemetria;
		}

		public function getAmbos(){
			return $this->ambos;
		}

		public function setAmbos($ambos){
			$this->ambos = $ambos;
		}

		public function getNumAntenaAmb(){
			return $this->numAntenaAmb;
		}

		public function setNumAntenaAmb($numAntenaAmb){
			$this->numAntenaAmb = $numAntenaAmb;
		}

		public function getComunicacaoAmb(){
			return $this->comunicacaoAmb;
		}

		public function setComunicacaoAmb($comunicacaoAmb){
			$this->comunicacaoAmb = $comunicacaoAmb;
		}

		public function getTemContrato(){
			return $this->temContrato;
		}

		public function setTemContrato($temContrato){
			$this->temContrato = $temContrato;
		}

	}