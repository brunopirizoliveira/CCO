<?php

require_once ('../model/includes/inc.autoload.php');
require_once('verificaAcesso.php');

$tpl = new TemplatePower('../view/_MASTER.html');
$tpl->assignInclude('content','../view/cadastro_fornecedor.html');
$tpl->assignInclude('aside','../view/checklist.html');

$tpl->prepare();

if($_SESSION['nivel'] == 2){
	$tpl->newBlock('admin');
}

// $tpl->newBlock( "currentPage" );
// $tpl->assign( "page", "Mapa" );

$tpl->printToScreen();
