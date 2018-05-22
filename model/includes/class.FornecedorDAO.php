<?php

require_once('inc.autoload.php');
require_once('inc.config.php');

Class FornecedorDAO {
	
	private $dba;

	public function FornecedorDAO() {

		$dba = new DbAdmin('oracle');
		$dba->connect(DBUSER,DBPASS,DBTNS);
		$this->dba = $dba;
	}

	public function lista() {

		$dba = $this->dba;

		$response = new stdClass();
		//$vet = array();
		
		$sql = 'SELECT 	DESCRICAO
				FROM	HS_CT_TECNOLOGIA_FORNECEDOR';
		
		/*$sql = 'SELECT 	* 
				FROM 	HS_CT_TECNOLOGIA_FORNECEDOR';*/
																						
		$res = $dba->query($sql);

		$i = 0;

			while (OCIFetchInto($res, $row, OCI_ASSOC)){
				
				$response->rows[$i]	= $row['DESCRICAO'];
											  
				$i++;
				
				/*$i = $i+1;
							
				$idForn  	 = $row['IDFORNECEDOR'];
				$descricao   = $row['DESCRICAO'];
				
				$forn = new Fornecedor();
					
				$forn->setIdFornecedor($idForn);
				$forn->setDescricao($descricao);
					
				$vet[$i] = $forn;*/
			}
				
		return $response;		
		//return $vet;
	}
	
		public function lista2() {

		$dba = $this->dba;

		$response = new stdClass();
		$vet = array();
		
		$sql = 'SELECT 	* 
				FROM 	HS_CT_TECNOLOGIA_FORNECEDOR';
																						
		$res = $dba->query($sql);

		$i = 0;

			while (OCIFetchInto($res, $row, OCI_ASSOC)){
				
				$i = $i+1;
							
				$idForn  	 = $row['IDFORNECEDOR'];
				$descricao   = $row['DESCRICAO'];
				
				$forn = new Fornecedor();
					
				$forn->setIdFornecedor($idForn);
				$forn->setDescricao($descricao);
					
				$vet[$i] = $forn;
			}
				
		
		return $vet;
	}
}