<?php

require_once('inc.autoload.php');
require_once('inc.config.php');

Class ItensDeTecnologiaDAO {

  private $dba;

  
  public function ItensDeTecnologiaDAO() {

    $dba = new DbAdmin('oracle');
		$dba->connect(DBUSER,DBPASS,DBTNS);
		$this->dba = $dba;
  }


  public function lista($idSubgrupo) {

		$dba = $this->dba;

		$vet = array();
		
		$sql = 'SELECT 	* 
				FROM 	hs_ct_itens_de_tecnologia
				WHERE IDSUBGRUPO ='.$idSubgrupo;
																						
		$res = $dba->query($sql);

		$i = 0;

			while (OCIFetchInto($res, $row, OCI_ASSOC)){
				
				$i = $i+1;
							
				$idItem  	 = $row['IDITEM'];
				$idSubgrupo  = $row['IDSUBGRUPO'];
				$descricao   = $row['DESCRICAO'];
				
				$item = new ItensDeTecnologia();
					
				$item->setIdItem(utf8_encode($idItem));
				$item->setIdSubgrupo(utf8_encode($idSubgrupo));
				$item->setDescricao(utf8_encode($descricao));
					
				$vet[$i] = $item;
			}
				
		return $vet;
	}


	// public function listaItensFrota() { // $frota, $idTecnologia

	// 	$dba = $this->dba;

	// 	$vet = array(); 	 

	// 	$sql = "SELECT  k.idtecnologiakit, t.idtecnologia, k.idsubgrupo, s.descricao as subgrupo, k.iditem, i.descricao as item
	// 			FROM    hs_ct_frota f, 
 //       					hs_ct_tecnologia t, 
 //       					hs_ct_tecnologia_kit k,
	// 			        hs_ct_itens_de_tecnologia i,
	// 			        hs_ct_tecnologia_subgrupo s
	// 			WHERE
	// 			       f.idfrota = t.idfrota and
	// 			       t.idtecnologia = k.idtecnologia and
	// 			       k.iditem = i.iditem and
	// 			       k.idsubgrupo = s.idsubgrupo and
	// 			       i.idsubgrupo = s.idsubgrupo and
	// 			       t.idtecnologia = 180 ";
				       

	// 	$res = $dba->query($sql);

	// 	$i = 0;

	// 		while (OCIFetchInto($res, $row, OCI_ASSOC)){
				
	// 			$i = $i+1;

	// 			$response = new stdClass();

	// 			$response->idKit        = $row['IDTECNOLOGIAKIT'];
	// 			$response->idTecnologia = $row['IDTECNOLOGIA'];
	// 			$response->idSubGrupo 	= $row['IDSUBGRUPO'];
	// 			$response->subGrupo   	= $row['SUBGRUPO'];
	// 			$response->itens[$i]  	= array('iditem' => $row['IDITEM'], 'item' => $row['ITEM']);

	// 			$vet[$i] = $response;
	// 		}		

	// 		// var_dump($vet);die;
	// 		return $vet;
	// }


}