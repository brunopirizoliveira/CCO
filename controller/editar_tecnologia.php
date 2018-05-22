<?php

require_once ('../model/includes/inc.autoload.php');
require_once('verificaAcesso.php');

$tpl = new TemplatePower('../view/_MASTER.html');
$tpl->assignInclude('content','../view/editar_tecnologia.html');

$tpl->prepare();

/**********************************************************************************************************************************************/

$idTecnologia = $_GET['idTecnologia'];

$tecDAO = new TecnologiaDAO();

$equip 	  = $tecDAO->buscaDadosEquipamentoEdita($idTecnologia); //Busca Dados Cabeçalho Equipamento

$idcco 			= $equip->idcco;
$idtecnologia 	= $equip->idtecnologia;
$idmedicao 		= $equip->idmedicao;
$idfornecedor   = $equip->idfornecedor;
$numAntena 		= $equip->numeroantena;
$serial			= $equip->serial;
$modelo			= $equip->modelo;
$tipo			= $equip->tipo;


$tpl->assign('idtecnologia',$idtecnologia);
$tpl->assign('idTecno',$idtecnologia);
$tpl->assign('idcco',$idcco);
$tpl->assign('idccoant',$idcco);
$tpl->assign('modelo',$modelo);
$tpl->assign('modeloant',$modelo);
$tpl->assign('serial',$serial);
$tpl->assign('serialant',$serial);
$tpl->assign('numAntena',$numAntena);
$tpl->assign('numAntenaant',$numAntena);

$kitEquip = $tecDAO->buscaDadosKitEquipamentoEdita($idTecnologia); //Busca Kit Equipamento

// ************* CAMPO FORNECEDOR ************* \\

$fornDAO = new FornecedorDAO();
$fornDAO = $fornDAO->lista2();

foreach($fornDAO as $key => $value){

	$forn = $fornDAO[$key];

	$idf		= $forn->getIdFornecedor();
	$fornecedor = $forn->getDescricao();

	$tpl->newBlock('fornecedor');

	$tpl->assign('idf',$idf);
	$tpl->assign('fornecedor',$fornecedor);

	if($idf == $idfornecedor) {
		$tpl->assign('idfornecedor','checked');
	}

}

// ************* CAMPO MEDIÇÃO ************* \\

$medDAO = new MedicoesDAO();
$medDAO = $medDAO->lista();

foreach($medDAO as $key => $value){
	
	$med = $medDAO[$key];
	
	$idm		= $med->getIdMed();
	$medicao 	= $med->getDescricao();
	
	$tpl->newBlock('medicoes');
	
	$tpl->assign('idm',$idm);
	$tpl->assign('medicao',$medicao);
	
	if($idm == $idmedicao) {
		$tpl->assign('idmedicao','checked');
	}

}

// ************* CAMPO TIPO ************* \\

$tipDAO = new TipoDAO();
$tipDAO = $tipDAO->lista();

foreach($tipDAO as $key => $value){
	
	$tip = $tipDAO[$key];
	
	$idtp		= $tip->getIdTip();
	$tipoE 		= $tip->getDescricao();
	
	$tpl->newBlock('tipo');
	
	$tpl->assign('idtp',$idtp);
	$tpl->assign('tipoE',$tipoE);
	
	if($idtp == $tipo) {
		$tpl->assign('idtipo','checked');
	}

}

// ********** Itens do Equipamento *************\\

$itemDAOC = new ItensDeTecnologiaDAO();

for($x=1;$x<6;$x++){

	$itemDAO = $itemDAOC->lista($x);

	foreach($itemDAO as $key => $value){

		$item = $itemDAO[$key];
		
		$idt		= $item->getIdItem();
		$tecnologia = $item->getDescricao();
		
		if($x == 1){ 		// Sub-Grupo Sensores
			$tpl->newBlock('sensores');
		}elseif($x == 2){ 	// Sub-Grupo Avisos
			$tpl->newBlock('avisos');
		}elseif($x == 3){	// Sub-Grupo Comunicação
			$tpl->newBlock('comunicacao');
		}elseif($x == 4){	// Sub-Grupo Atuadores
			$tpl->newBlock('atuadores');
		}elseif($x == 5){	// Sub-Grupo Sinal
			$tpl->newBlock('sinal');
		}

		$tpl->assign('idt',$idt);				
		$tpl->assign('tecnologia',$tecnologia);	

		foreach($kitEquip as $key => $value){

			$kit = $kitEquip[$key];					

			if($idt == $kit->iditem) {
				$tpl->assign('checked',"checked");
			}

		}

	}
	
}

if($_SESSION['nivel'] == 2){
	$tpl->newBlock('admin');
}



/**********************************************************************************************************************************************/

$tpl->printToScreen();