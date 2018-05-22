<?php

require_once ('../model/includes/inc.autoload.php');
require_once('verificaAcesso.php');

$tpl = new TemplatePower('../view/_MASTER.html');
$tpl->assignInclude('content','../view/cadastro_tecnologia.html');
$tpl->assignInclude('aside','../view/checklist.html');

$tpl->prepare();

/* **************************************************************************** */

// ************* CAMPOS TECNOLOGIA ************* \\

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
	}
	
}

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
	
	if($idtp == $tpo) {
		$tpl->assign('idtipo','checked');
	}

}

if($_SESSION['nivel'] == 2){
	$tpl->newBlock('admin');
}
// $tpl->newBlock( "currentPage" );
// $tpl->assign( "page", "Mapa" );

$tpl->printToScreen();
