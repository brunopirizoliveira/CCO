<?php

require_once('inc.autoload.php');
require_once('inc.config.php');

Class TecnologiaDAO {
	
	private $dba;

	
	public function TecnologiaDAO() {

		$dba = new DbAdmin('oracle');
		$dba->connect(DBUSER,DBPASS,DBTNS);
    	$this->dba = $dba;
	}


	public function insertTecnologia($medicao, $idcco, $numAntena, $serial, $fornecedor, $modelo, $tipo) {

		$dba = $this->dba;
		if($medicao && $idcco && $fornecedor && $modelo && $tipo) {

			$sql = "INSERT INTO HS_CT_TECNOLOGIA (IDTECNOLOGIA, IDMEDICAO, IDCCO, NUMEROANTENA, NUMSERIAL, IDFORNECEDOR, MODELO, IDTIPO, IN_FROTA, IDTECNOLOGIAORIGINAL)
				VALUES 		(seq_hs_ct_tecnologia.NEXTVAL, '".$medicao."', '".$idcco."','".$numAntena."', '".$serial."', '".$fornecedor."', '".$modelo."','".$tipo."', 'N', seq_hs_ct_tecnologia.CURRVAL)";
		
			if($dba->query($sql)) {
				$sqli = "SELECT seq_hs_ct_tecnologia.currval as idtecnologia FROM dual";
				$stmt = $dba->query($sqli);
				$res = oci_fetch_array($stmt, OCI_ASSOC);
				$idTecnologia = $res['IDTECNOLOGIA'];
			}

			return $idTecnologia;	
		
		} else {
			return false;
		}
		
	}


	public function updateTecnologia($medicao, $idcco, $numAntena, $serial, $fornecedor, $modelo, $tipo, $idtecnologia) {

		$dba = $this->dba;

		$sql = "UPDATE HS_CT_TECNOLOGIA SET IDMEDICAO = $medicao, IDCCO = '$idcco', NUMEROANTENA = '$numAntena', 
											IDFORNECEDOR = $fornecedor, MODELO = '$modelo', IDTIPO = $tipo,
											NUMSERIAL = $serial
				WHERE IDTECNOLOGIA = $idtecnologia ";		
				
		$sql2 = "UPDATE HS_CT_TECNOLOGIA SET IDMEDICAO = $medicao, IDCCO = '$idcco', NUMEROANTENA = '$numAntena', 
											IDFORNECEDOR = $fornecedor, MODELO = '$modelo', IDTIPO = $tipo,
											NUMSERIAL = $serial
				WHERE IDTECNOLOGIA = (
										SELECT	IDTECNOLOGIAORIGINAL
										FROM	HS_CT_TECNOLOGIA
										WHERE	IDTECNOLOGIA = '$idTecnologia'
									 ) ";
		

		if($dba->query($sql)){	
			if($dba->query($sql2)){
				return true;
			}else{
				return false;
			}
		}else{
			return false;	
		}
	}


	public function insertKit($idTecnologia, $arr, $subgrupo) {

		$dba = $this->dba;

		$success = array('sucesso');

		if($arr) {
			
			foreach($arr as $key => $val) {

				$sql = "INSERT INTO HS_CT_TECNOLOGIA_KIT (IDTECNOLOGIAKIT, IDTECNOLOGIA, IDSUBGRUPO, IDITEM)
						VALUES 		(seq_hs_ct_tecnologia_kit.NEXTVAL, '".$idTecnologia."', '".$subgrupo."', '".$val."')";
						
				$sql2 = "INSERT INTO HS_CT_TECNOLOGIA_KIT (IDTECNOLOGIAKIT, IDSUBGRUPO, IDITEM, IDTECNOLOGIA)
						VALUES 		(seq_hs_ct_tecnologia_kit.NEXTVAL, '".$subgrupo."', '".$val."', (SELECT IDTECNOLOGIAORIGINAL
																									 FROM HS_CT_TECNOLOGIA
																									 WHERE IDTECNOLOGIA = '".$idTecnologia."'))";

				if($dba->query($sql)){
					$dba->query($sql2);
					array_push($success, 'sucesso');
				}else{
					array_push($success, 'erro');	
				}
			}
		}		

		if(in_array('erro', $success))
			return 'erro';
		else 
			return 'sucesso';
	}

	public function deleteKit($idTecnologia) {

		$dba = $this->dba;

		$sql = "DELETE FROM HS_CT_TECNOLOGIA_KIT WHERE IDTECNOLOGIA = $idTecnologia ";
		
		$sql2 = "DELETE FROM HS_CT_TECNOLOGIA_KIT WHERE IDTECNOLOGIA = (SELECT IDTECNOLOGIAORIGINAL
																		FROM HS_CT_TECNOLOGIA
																		WHERE IDTECNOLOGIA = '".$idTecnologia."')";

		if($dba->query($sql)){
			$dba->query($sql2);
			return true;
		}else{
			return false;
		}
	}


	public function buscaDadosEquipamento($fornecedor, $medicao) {

		$dba = $this->dba;

		$sql = "SELECT	DISTINCT
						T.IDTECNOLOGIA,
						T.IDCCO,
						T.NUMEROANTENA

				FROM	HS_CT_TECNOLOGIA T,
						HS_CT_TECNOLOGIA_KIT TK,
						HS_CT_TECNOLOGIA_SUBGRUPO TS,
						HS_CT_TECNOLOGIA_MEDICAO TM,
						HS_CT_TECNOLOGIA_FORNECEDOR TF,
						HS_CT_ITENS_DE_TECNOLOGIA I
						
				WHERE	T.IDTECNOLOGIA = TK.IDTECNOLOGIA
					AND	T.IDFORNECEDOR = TF.IDFORNECEDOR
					AND	TK.IDITEM = I.IDITEM
					AND	I.IDSUBGRUPO = TK.IDSUBGRUPO
					AND	T.IDMEDICAO = TM.IDMEDICAO
					AND	TK.IDSUBGRUPO = TS.IDSUBGRUPO
					AND T.IDFROTA IS NULL
					AND T.IN_FROTA = 'N'
					AND T.IDMEDICAO = '$medicao'
					AND TF.IDFORNECEDOR = '$fornecedor'
					
				ORDER BY IDTECNOLOGIA";

		$stmt = $dba->query($sql);

		$response = new stdClass();

		$i = 0;

		while(OciFetchInto($stmt, $row, OCI_ASSOC)) {

			$response->dados[$i]['idtecnologia'] = $row['IDTECNOLOGIA'];
			$response->dados[$i]['idcco']		 = $row['IDCCO'];
			$response->dados[$i]['numeroantena'] = $row['NUMEROANTENA'];

			$i = $i+1;
		}
		
		return $response;
	}

	public function associaTecnologiaFrota($response) {

		$bool = true;

		$frtId 			   = $response->idFrota;
		
		$frtIdTecnologia1  = $response->idTecnologia1;
		$frtDtInstalacao1  = $response->dtInstalacao1;
		
		$frtIdTecnologia2  = $response->idTecnologia2;
		$frtDtInstalacao2  = $response->dtInstalacao2;
		
		$frtIdTecnologia3  = $response->idTecnologia3;
		$frtDtInstalacao3  = $response->dtInstalacao3;

		$dba = $this->dba;

		if($frtIdTecnologia1) {

			$sql = "UPDATE	HS_CT_TECNOLOGIA
					SET		IN_FROTA = 'S'
					WHERE	IDTECNOLOGIA = '$frtIdTecnologia1'";
					
			$sqlc = "INSERT	INTO	HS_CT_TECNOLOGIA
					(
						IDTECNOLOGIA,
						IDMEDICAO,
						IDCCO,
						NUMEROANTENA,
						NUMSERIAL,
						DATAINSTALACAO,
						IDFROTA,
						IDFORNECEDOR,
						MODELO,
						IDTIPO,
						IN_FROTA,
						IDTECNOLOGIAORIGINAL
					)
					
					SELECT	SEQ_HS_CT_TECNOLOGIA.NEXTVAL,
							IDMEDICAO,
							IDCCO,
							NUMEROANTENA,
							NUMSERIAL,
							'$frtDtInstalacao1',
							'$frtId',
							IDFORNECEDOR,
							MODELO,
							IDTIPO,
							'S',
							IDTECNOLOGIA
							
					FROM	HS_CT_TECNOLOGIA
					
					WHERE	IDTECNOLOGIA = '$frtIdTecnologia1'";
					
			$sqlk = "INSERT 	INTO	HS_CT_TECNOLOGIA_KIT
					(
						IDTECNOLOGIAKIT,
						IDTECNOLOGIA,
						IDSUBGRUPO,
						IDITEM
					)
					
					SELECT	SEQ_HS_CT_TECNOLOGIA_KIT.NEXTVAL,
							(SELECT 	IDTECNOLOGIA
							FROM    HS_CT_TECNOLOGIA
							WHERE   DATAINSTALACAO = '$frtDtInstalacao1'
							  AND   IDFROTA = '$frtId'
							  AND   IN_FROTA = 'S'	
							  AND   IDTECNOLOGIAORIGINAL = '$frtIdTecnologia1'),
							IDSUBGRUPO,
							IDITEM
							
					FROM	HS_CT_TECNOLOGIA_KIT
					
					WHERE	IDTECNOLOGIA = '$frtIdTecnologia1'";

			if(!$dba->query($sql)){
				$bool = false;
			}
			
			if(!$dba->query($sqlc)){
				$bool = false;
			}
			
			if(!$dba->query($sqlk)){
				$bool = false;
			}
		}
		
		if($frtIdTecnologia2) {

			$sql = "UPDATE	HS_CT_TECNOLOGIA
					SET		IN_FROTA = 'S'
					WHERE	IDTECNOLOGIA = '$frtIdTecnologia2'";
					
			$sqlc = "INSERT	INTO	HS_CT_TECNOLOGIA
					(
						IDTECNOLOGIA,
						IDMEDICAO,
						IDCCO,
						NUMEROANTENA,
						NUMSERIAL,
						DATAINSTALACAO,
						IDFROTA,
						IDFORNECEDOR,
						MODELO,
						IDTIPO,
						IN_FROTA,
						IDTECNOLOGIAORIGINAL
					)
					
					SELECT	SEQ_HS_CT_TECNOLOGIA.NEXTVAL,
							IDMEDICAO,
							IDCCO,
							NUMEROANTENA,
							NUMSERIAL,
							'$frtDtInstalacao2',
							'$frtId',
							IDFORNECEDOR,
							MODELO,
							IDTIPO,
							'S',
							IDTECNOLOGIA
							
					FROM	HS_CT_TECNOLOGIA
					
					WHERE	IDTECNOLOGIA = '$frtIdTecnologia2'";
					
			$sqlk = "INSERT 	INTO	HS_CT_TECNOLOGIA_KIT
					(
						IDTECNOLOGIAKIT,
						IDTECNOLOGIA,
						IDSUBGRUPO,
						IDITEM
					)
					
					SELECT	SEQ_HS_CT_TECNOLOGIA_KIT.NEXTVAL,
							(SELECT 	IDTECNOLOGIA
							FROM    HS_CT_TECNOLOGIA
							WHERE   DATAINSTALACAO = '$frtDtInstalacao2'
							  AND   IDFROTA = '$frtId'
							  AND   IN_FROTA = 'S'	
							  AND   IDTECNOLOGIAORIGINAL = '$frtIdTecnologia2'),
							IDSUBGRUPO,
							IDITEM
							
					FROM	HS_CT_TECNOLOGIA_KIT
					
					WHERE	IDTECNOLOGIA = '$frtIdTecnologia2'";

			if(!$dba->query($sql)){
				$bool = false;
			}
			
			if(!$dba->query($sqlc)){
				$bool = false;
			}
			
			if(!$dba->query($sqlk)){
				$bool = false;
			}
		}
		
		if($frtIdTecnologia3) {

			$sql = "UPDATE	HS_CT_TECNOLOGIA
					SET		IN_FROTA = 'S'
					WHERE	IDTECNOLOGIA = '$frtIdTecnologia3'";
					
			$sqlc = "INSERT	INTO	HS_CT_TECNOLOGIA
					(
						IDTECNOLOGIA,
						IDMEDICAO,
						IDCCO,
						NUMEROANTENA,
						NUMSERIAL,
						DATAINSTALACAO,
						IDFROTA,
						IDFORNECEDOR,
						MODELO,
						IDTIPO,
						IN_FROTA,
						IDTECNOLOGIAORIGINAL
					)
					
					SELECT	SEQ_HS_CT_TECNOLOGIA.NEXTVAL,
							IDMEDICAO,
							IDCCO,
							NUMEROANTENA,
							NUMSERIAL,
							'$frtDtInstalacao3',
							'$frtId',
							IDFORNECEDOR,
							MODELO,
							IDTIPO,
							'S',
							IDTECNOLOGIA
							
					FROM	HS_CT_TECNOLOGIA
					
					WHERE	IDTECNOLOGIA = '$frtIdTecnologia3'";
					
			$sqlk = "INSERT 	INTO	HS_CT_TECNOLOGIA_KIT
					(
						IDTECNOLOGIAKIT,
						IDTECNOLOGIA,
						IDSUBGRUPO,
						IDITEM
					)
					
					SELECT	SEQ_HS_CT_TECNOLOGIA_KIT.NEXTVAL,
							(SELECT 	IDTECNOLOGIA
							FROM    HS_CT_TECNOLOGIA
							WHERE   DATAINSTALACAO = '$frtDtInstalacao3'
							  AND   IDFROTA = '$frtId'
							  AND   IN_FROTA = 'S'	
							  AND   IDTECNOLOGIAORIGINAL = '$frtIdTecnologia3'),
							IDSUBGRUPO,
							IDITEM
							
					FROM	HS_CT_TECNOLOGIA_KIT
					
					WHERE	IDTECNOLOGIA = '$frtIdTecnologia3'";

			if(!$dba->query($sql)){
				$bool = false;
			}
			
			if(!$dba->query($sqlc)){
				$bool = false;
			}
			
			if(!$dba->query($sqlk)){
				$bool = false;
			}
		}
		

		return $bool;
	}

	public function getDadosEquip($inicio, $final, $where) {

		$dba = $this->dba;

		$sql = "SELECT TAB.* FROM 
	              ((SELECT distinct Row_Number() OVER (ORDER BY h.idtecnologia ASC) a,
	                h.idtecnologia, h.idtecnologiaoriginal, h.in_frota, h.idcco, h.modelo, fo.descricao as fornecedor, m.descmedicao as medicao,
	                (select tp.descricao from hs_ct_tecnologia_tipo tp where tp.idtipo = h.idtipo) as idtipo, 
	                f.prefixo, f.placa, f.marca, f.operacao, f.filial, h.datainstalacao, 
	                f.tipo as tpFrota, f.situacao
	              FROM 
	                hs_ct_tecnologia h,
	                hs_ct_frota f,
	                hs_ct_tecnologia_medicao m,
	                hs_ct_tecnologia_fornecedor fo

	              WHERE
	                f.idfrota        = h.idfrota       AND
	                h.idmedicao      = m.idmedicao and
	                h.idfornecedor   = fo.idfornecedor and
	                h.idtecnologia  != h.idtecnologiaoriginal and
	                h.in_frota       = 'S' )
	                
	              UNION

	              (SELECT distinct Row_Number() OVER (ORDER BY h.idtecnologia ASC) a,
	                h.idtecnologia, h.idtecnologiaoriginal, h.in_frota, h.idcco, h.modelo, f.descricao as fornecedor, m.descmedicao as medicao, 
	                (select tp.descricao from hs_ct_tecnologia_tipo tp where tp.idtipo = h.idtipo) as idtipo,
	                '' as prefixo, '' as placa, '' as marca, '' as operacao, '' as filial, h.datainstalacao,
	                '' as tpFrota, '' as situacao
	              FROM
	                 hs_ct_tecnologia h,
	                 hs_ct_tecnologia_medicao m,
	                 hs_ct_tecnologia_fornecedor f
	              WHERE
	                 h.idtecnologia = h.idtecnologiaoriginal and
	                 h.idmedicao = m.idmedicao and
	                 h.idfornecedor = f.idfornecedor and
	                 h.in_frota = 'N' and
	                 h.idfrota is null)) TAB 
	            WHERE 
	              tab.a >  $inicio AND 
	              tab.a <= $final 
					$where";
				
		$stmt = $dba->query($sql);

    	$i = 0;

	    while(OciFetchInto($stmt, $row, OCI_ASSOC)) {
		  
			$i = $i+1;	

			$equipamentos = new stdClass();

			$equipamentos->idTecnologia   = $row['IDTECNOLOGIA'];
			$equipamentos->idcco 		  = $row['IDCCO'];
			$equipamentos->modelo         = $row['MODELO'];
			$equipamentos->tipo           = $row['IDTIPO'];
			$equipamentos->prefixo	  	  = $row['PREFIXO'];
			$equipamentos->placa		  = $row['PLACA'];
			$equipamentos->marca		  = $row['MARCA'];
			$equipamentos->operacao	      = $row['OPERACAO'];
			$equipamentos->filial		  = $row['FILIAL'];
			$equipamentos->dtInstalacao   = $row['DATAINSTALACAO'];
			$equipamentos->tpFrota	  	  = $row['TPFROTA'];
			$equipamentos->situacao	      = $row['SITUACAO'];
			$equipamentos->fornecedor     = $row['FORNECEDOR'];
			$equipamentos->medicao 		  = $row['MEDICAO'];
						
			$vet[$i] = $equipamentos;  
		}

		return $vet;
	}

	public function getTotalEquip() {

		$dba = $this->dba;

		$sql = "SELECT 
				  COUNT(*) AS QTD
				FROM 
				  hs_ct_tecnologia h				  
				LEFT JOIN
					hs_ct_frota f
				ON
				  f.idfrota = h.idfrota ";

		$stmt  = $dba->query($sql);
		$res   = oci_fetch_array($stmt, OCI_ASSOC);
		$total = $res['QTD'];	

		return $total;
	}
	
	public function desassociaTecnologiaFrota($idFrota, $idTecnologia, $motivo, $dtExclusao) {
		
		$dba = $this->dba;
				
		$sql = "UPDATE	HS_CT_TECNOLOGIA
				SET		IN_FROTA = 'N',
						DATADESINSTALACAO = '$dtExclusao',
						MOTIVODESINSTALACAO = '$motivo'
				WHERE	IDTECNOLOGIA = '$idTecnologia'";
		
		$sqls = "UPDATE	HS_CT_TECNOLOGIA
				 SET	IN_FROTA = 'N'
				 WHERE	IDTECNOLOGIA = (SELECT	IDTECNOLOGIAORIGINAL
										FROM	HS_CT_TECNOLOGIA
										WHERE	IDTECNOLOGIA = '$idTecnologia')";
										
		if($dba->query($sql)){
			$dba->query($sqls);
		}
	
	}
	
	public function editAssociaTecnologiaFrota($frtId, $frtIdTecnologia, $dtInstalacao) {
		
		$dba = $this->dba;
		
		$sql = "UPDATE	HS_CT_TECNOLOGIA
				SET		IN_FROTA = 'S'
				WHERE	IDTECNOLOGIA = '$frtIdTecnologia'";
				
		$sqlc = "INSERT	INTO	HS_CT_TECNOLOGIA
				(
					IDTECNOLOGIA,
					IDMEDICAO,
					IDCCO,
					NUMEROANTENA,
					NUMSERIAL,
					DATAINSTALACAO,
					IDFROTA,
					IDFORNECEDOR,
					MODELO,
					IDTIPO,
					IN_FROTA,
					IDTECNOLOGIAORIGINAL
				)
				
				SELECT	SEQ_HS_CT_TECNOLOGIA.NEXTVAL,
						IDMEDICAO,
						IDCCO,
						NUMEROANTENA,
						NUMSERIAL,
						'$dtInstalacao',
						'$frtId',
						IDFORNECEDOR,
						MODELO,
						IDTIPO,
						'S',
						IDTECNOLOGIA
						
				FROM	HS_CT_TECNOLOGIA
				
				WHERE	IDTECNOLOGIA = '$frtIdTecnologia'";
				
		$sqlk = "INSERT 	INTO	HS_CT_TECNOLOGIA_KIT
				(
					IDTECNOLOGIAKIT,
					IDTECNOLOGIA,
					IDSUBGRUPO,
					IDITEM
				)
				
				SELECT	SEQ_HS_CT_TECNOLOGIA_KIT.NEXTVAL,
						(SELECT 	IDTECNOLOGIA
						FROM    HS_CT_TECNOLOGIA
						WHERE   DATAINSTALACAO = '$dtInstalacao'
						  AND   IDFROTA = '$frtId'
						  AND   IN_FROTA = 'S'	
						  AND   IDTECNOLOGIAORIGINAL = '$frtIdTecnologia'),
						IDSUBGRUPO,
						IDITEM
						
				FROM	HS_CT_TECNOLOGIA_KIT
				
				WHERE	IDTECNOLOGIA = '$frtIdTecnologia'";
				
		if($dba->query($sql)){
			$dba->query($sqlc);
			$dba->query($sqlk);
			$sqli = "SELECT seq_hs_ct_tecnologia.currval as IDTECNOLOGIAORIGINAL FROM dual";
			$stmt = $dba->query($sqli);
			$res = oci_fetch_array($stmt, OCI_ASSOC);
			$idTecnologiaOrg = $res['IDTECNOLOGIAORIGINAL'];
		}

		return $idTecnologiaOrg;
		
	}

	public function  buscaDadosEquipamentoEdita($idtecnologia) {

		$dba = $this->dba;

		$sql = "SELECT  h.idtecnologia, 
				        h.idmedicao, 
				        h.idcco, 
				        h.numeroantena, 
						h.numserial,
				        h.idfornecedor, 
				        h.modelo, 
				        h.idtipo
				FROM 
				     hs_ct_tecnologia h
				WHERE 
				     h.idtecnologia = $idtecnologia ";

		$stmt = $dba->query($sql);
		

	    while(OciFetchInto($stmt, $row, OCI_ASSOC)) {
		  
			$equipamentos = new stdClass();

			$equipamentos->idtecnologia 	= $row['IDTECNOLOGIA'];
			$equipamentos->idmedicao 		= $row['IDMEDICAO'];
			$equipamentos->idcco 			= $row['IDCCO'];
			$equipamentos->numeroantena 	= $row['NUMEROANTENA'];
			$equipamentos->serial			= $row['NUMSERIAL'];
			$equipamentos->idfornecedor 	= $row['IDFORNECEDOR'];
			$equipamentos->modelo 			= $row['MODELO'];
			$equipamentos->tipo 			= $row['IDTIPO'];

		}	

		return $equipamentos;
	}


	public function buscaDadosKitEquipamentoEdita($idtecnologia) {

		$dba = $this->dba;

		$vet = array();

		$sql = "SELECT  k.idtecnologiakit, 
				        k.idsubgrupo, 
				        k.iditem
				FROM 				     
				     hs_ct_tecnologia_kit k 
				WHERE 
				     k.idtecnologia = $idtecnologia ";

		$stmt = $dba->query($sql);

		$i=0;

		while(OciFetchInto($stmt, $row, OCI_ASSOC)) {

			$i = $i+1;

			$kit = new stdClass();

			$kit->idtecnologiakit = $row['IDTECNOLOGIAKIT'];
			$kit->subgrupo 		  = $row['IDSUBGRUPO'];
			$kit->iditem 		  = $row['IDITEM'];

			$vet[$i] = $kit;
		}

		return $vet;
	}

}

