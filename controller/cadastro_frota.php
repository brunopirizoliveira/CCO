<?php

require_once ('../model/includes/inc.autoload.php');
require_once('verificaAcesso.php');

$tpl = new TemplatePower('../view/_MASTER.html');
$tpl->assignInclude('content','../view/cadastro_frota.html');
// $tpl->assignInclude('aside','../view/checklist.html');

$tpl->prepare();


if($_SESSION['nivel'] == 2){
	$tpl->newBlock('admin');
}

/*******************************************************************************************************************************************************/

/*$fornDAO = new FornecedorDAO();
$fornDAO = $fornDAO->lista();

foreach($fornDAO as $key => $value){

	$forn = $fornDAO[$key];

	$idf		= $forn->getIdFornecedor();
	$fornecedor = $forn->getDescricao();

	$tpl->newBlock('fornecedor');

	$tpl->assign('idf',$idf);
	$tpl->assign('fornecedor',$fornecedor);

	$tpl->newBlock('fornecedor-telemetria');

	$tpl->assign('idf',$idf);
	$tpl->assign('fornecedor',$fornecedor);

}*/

/*******************************************************************************************************************************************************/

$tpl->printToScreen();
