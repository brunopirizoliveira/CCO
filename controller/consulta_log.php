<?php

require_once ('../model/includes/inc.autoload.php');
require_once('verificaAcesso.php');

$tpl = new TemplatePower('../view/_MASTER.html');
$tpl->assignInclude('content','../view/consulta_log.html');

$tpl->prepare();

if($_SESSION['nivel'] == 2){
	$tpl->newBlock('admin');
	$tpl->newBlock('_admin');
}else{
	$tpl->newBlock('user');
}

/*******************************************************************************************************************************************************/

$logUsuario = $_POST['logUsuario'];
$logDtIni = $_POST['logDtIni'];
$logDtFim = $_POST['logDtFim'];

$tpl->assign('logUsuario',$logUsuario);
$tpl->assign('logDtIni',$logDtIni);
$tpl->assign('logDtFim',$logDtFim);

$logDAO = new LogDAO();
$logDAO = $logDAO->buscaLog($logUsuario, $logDtIni, $logDtFim);

if($logDAO){
	foreach($logDAO as $key => $value){
		
		$log = $logDAO[$key];
		
		$usuario 	= $log->getUsuario();
		$data 		= $log->getDataLog();
		$dataHora	= $log->getDataHoraLog();
		$textoLog	= $log->getTextoLog();
		$ipAdress	= $log->getIpAdress();
		
		$tpl->newBlock('log');
		
		$tpl->assign('usuario',$usuario);
		$tpl->assign('data',$data);
		$tpl->assign('datahora',$dataHora);
		$tpl->assign('textoLog',$textoLog);
		$tpl->assign('ipAdress',$ipAdress);
		
	}
}

/*******************************************************************************************************************************************************/

$tpl->printToScreen();
