<?php

require_once('inc.autoload.php');
require_once('inc.config.php');

class FiltrosDAO {
	
	private $dba;
	
	public function FiltrosDAO() {
		
		$dba = new DbAdmin('oracle');
		$dba->connect(DBUSER,DBPASS,DBTNS);
		$this->dba = $dba;
	}
	
	public function lista($campo, $situacao) {
		$dba = $this->dba;
		
		$vet = array();
		
		$sql = "SELECT DISTINCT $campo
				FROM hs_ct_frota
				WHERE situacao = '$situacao'";
		
		$res = $dba->query($sql);
		
		$i = 0;
		
		while (OCIFetchInto($res, $row, OCI_ASSOC)){
			
			$filtro = new Filtros();
			
			if ($row['FILIAL'] != NULL){
				$filial		= $row['FILIAL'];
				$filtro->setFilial($filial);
			}
			if ($row['OPERACAO'] != NULL){
				$operacao 	= $row['OPERACAO'];
				$filtro->setOperacao($operacao);
			}
			if ($row['TIPO'] != NULL){
				$tpFrota	= $row['TIPO'];
				$filtro->setTpFrota($tpFrota);
			}
				
			
			$vet[$i] = $filtro;
			$i = $i + 1;
		}
		
		return $vet;
	}
	
}