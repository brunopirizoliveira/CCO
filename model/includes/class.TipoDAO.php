<?php

require_once('inc.autoload.php');
require_once('inc.config.php');

Class TipoDAO {
	
	private $dba;

	public function TipoDAO() {

		$dba = new DbAdmin('oracle');
		$dba->connect(DBUSER,DBPASS,DBTNS);
		$this->dba = $dba;
	}

	public function lista() {

		$dba = $this->dba;

		$vet = array();
		
		$sql = 'SELECT 	* 
				FROM 	HS_CT_TECNOLOGIA_TIPO';
																						
		$res = $dba->query($sql);

		$i = 0;

			while (OCIFetchInto($res, $row, OCI_ASSOC)){
				
				$i = $i+1;
							
				$idTip  	 = $row['IDTIPO'];
				$descricao   = $row['DESCRICAO'];
				
				$tip = new Tipo();
					
				$tip->setIdTip($idTip);
				$tip->setDescricao($descricao);
					
				$vet[$i] = $tip;
			}
				
		return $vet;
	}
}