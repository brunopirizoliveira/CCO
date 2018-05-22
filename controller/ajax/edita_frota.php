<?php

	require_once ('../../model/includes/inc.autoload.php');
	require_once('../../controller/verificaAcesso.php');
	
	$action = $_REQUEST['action'];
	
	$logDAO = new LogDAO();
	
	switch($action){
		case 'desassociaTecnologiaFrota': 
			$idFrota = $_REQUEST['idFrota'];
			$idTecnologia = $_REQUEST['idTecnologia'];
			$idTecnologiaOrg = $_REQUEST['idTecnologiaOrg'];
			$motivo = utf8_decode($_REQUEST['motivo']);
			$dtExclusao = $_REQUEST['dtExclusao'];			
			
			if($idFrota){
				$tecDAO = new TecnologiaDAO();
				$exec = $tecDAO->desassociaTecnologiaFrota($idFrota, $idTecnologia, $motivo, $dtExclusao);
				
				$textoLog = utf8_decode("Alteração - Frota: ".$idFrota." | Tecnologia desvinculada: ".$idTecnologia." (".$idTecnologiaOrg.")");
			}
			break;
			
		case 'associaTecnologiaFrota':
			$idFrota = $_REQUEST['idFrota'];
			$idTecnologia = $_REQUEST['idTecnologia'];
			$dtInstalacao = $_REQUEST['dtInstalacao'];
			
			if($idFrota){
				$tecDAO = new TecnologiaDAO();
				$exec = $tecDAO->editAssociaTecnologiaFrota($idFrota, $idTecnologia, $dtInstalacao);
				
				$textoLog = utf8_decode("Alteração - Frota: ".$idFrota." | Tecnologia associada: ".$exec." (".$idTecnologia.")");
			}
			break;
			
		case 'alteraSituacaoFrota':
			$sit = $_REQUEST['sitFrota'];
			$idFrota = $_REQUEST['idFrota'];
			
			if($sit == "I"){
				$situacao = "INATIVO";
			}else{
				if($sit == "A"){
					$situacao = "ATIVO";
				}
			}
			
			if($idFrota){
				$frotaDAO = new FrotaDAO();
				$exec = $frotaDAO->alteraSituacaoFrota($sit, $idFrota);
				
				$textoLog = utf8_decode("Alteração - Frota: ".$idFrota." | Situação: ".$situacao);
				
			}
			
			
			break;
			
		
		default:
			break;
	}
	
	$logDAO->insertLog($textoLog);