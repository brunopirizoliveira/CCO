<?php

require_once('inc.autoload.php');
require_once('inc.config.php');

Class SubgrupoDAO {

  private $dba;

  public function SubgrupoDAO() {

    $dba = new DbAdmin('oracle');
		$dba->connect(DBUSER,DBPASS,DBTNS);
		$this->dba = $dba;
  }


  public function lista() {

		$dba = $this->dba;

		$vet = array();
		
		$sql = 'SELECT 	* 
				FROM 	HS_CT_TECNOLOGIA_SUBGRUPO';
																						
		$res = $dba->query($sql);

		$i = 0;

			while (OCIFetchInto($res, $row, OCI_ASSOC)){
				
				$i = $i+1;
							
				$idSubgrupo  	 = $row['IDSUBGRUPO'];
				$descricao   	 = $row['DESCRICAO'];
				
				$sub = new Subgrupo();
					
				$sub->setIdSubgrupo($idSubgrupo);
				$sub->setDescricao($descricao);
					
				$vet[$i] = $sub;
			}
				
		return $vet;
	}

}
