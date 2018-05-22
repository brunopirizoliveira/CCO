<?php

require_once ('../../model/includes/inc.autoload.php');
require_once('../../controller/verificaAcesso.php');

$idFrota = $_REQUEST['idFrota'];
$form    = $_REQUEST['form'];

$frotaDAO = new FrotaDAO();
$tecDAO   = new TecnologiaDAO();
$logDAO	  = new LogDAO();

if(!$idFrota) {
  
  $response = $frotaDAO->insertFrota($form);

  $bool = $tecDAO->associaTecnologiaFrota($response);

  if($bool = true)
  	echo 'S';
  else
  	echo 'N';

  $idFrt = $response->idFrota;
  
  $textoLog = utf8_decode("Cadastro - Frota: ".$idFrt);
  $logDAO->insertLog($textoLog);

//} else {
//  var_dump('sim idfrota');
//}
 } else {

   $att = $form;
   parse_str($att);
	
   $frotaDAO->updateFrota($form, $idFrota);

     if($frtProprietario != $frtProprietarioOld){
 		$textoLog = utf8_decode("Alteração - Frota: ".$idFrota." | Proprietario: ".$frtProprietario);
 		$logDAO->insertLog($textoLog); 
   }
   if($frtLogin != $frtLoginOld){
 		$textoLog = utf8_decode("Alteração - Frota: ".$idFrota." | Login: ".$frtLogin);
 		$logDAO->insertLog($textoLog); 
   }
   if($frtSenha != $frtSenhaOld){
 		$textoLog = utf8_decode("Alteração - Frota: ".$idFrota." | Senha: ".$frtSenha);
 		$logDAO->insertLog($textoLog); 
   }
		 
   echo 'A';

  
 }