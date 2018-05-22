<?php

require_once('inc.autoload.php');
require_once('inc.config.php');

Class MedicoesDAO {
	
	private $dba;

	public function MedicoesDAO() {

		$dba = new DbAdmin('oracle');
		$dba->connect(DBUSER,DBPASS,DBTNS);
		$this->dba = $dba;
	}

	public function lista() {

		$dba = $this->dba;

		$vet = array();
		
		$sql = 'SELECT 	* 
				FROM 	HS_CT_TECNOLOGIA_MEDICAO';
																						
		$res = $dba->query($sql);

		$i = 0;

			while (OCIFetchInto($res, $row, OCI_ASSOC)){
				
				$i = $i+1;
							
				$idMed  	 = $row['IDMEDICAO'];
				$descricao   = $row['DESCMEDICAO'];
				
				$med = new Medicoes();
					
				$med->setIdMed($idMed);
				$med->setDescricao($descricao);
					
				$vet[$i] = $med;
			}
				
		return $vet;
	}
}