<?php

require_once ('../model/includes/inc.autoload.php');
require_once('verificaAcesso.php');

$tpl = new TemplatePower('../view/_MASTER.html');
$tpl->assignInclude('content','../view/cadastro_usuario.html');

$tpl->prepare();

if($_SESSION['nivel'] == 2){
	$tpl->newBlock('admin');
	$tpl->newBlock('_admin');
}else{
	$tpl->newBlock('user');
}

/*******************************************************************************************************************************************************/

/*******************************************************************************************************************************************************/

$tpl->printToScreen();
