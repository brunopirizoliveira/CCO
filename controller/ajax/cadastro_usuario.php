<?php

require_once ('../../model/includes/inc.autoload.php');
require_once('../../controller/verificaAcesso.php');

$cadNome = $_REQUEST['cadNome'];
$cadEmpresa = $_REQUEST['cadEmpresa'];
$cadLogin = $_REQUEST['cadLogin'];
$cadSenha = $_REQUEST['cadSenha'];
$cadNvlAcesso = $_REQUEST['cadNvlAcesso'];

$usuarioDAO = new UsuarioDAO();

$logDAO	  = new LogDAO();

$response = $usuarioDAO->cadastraUsuario($cadNome, $cadEmpresa, $cadLogin, $cadSenha, $cadNvlAcesso);

echo $response;
 
$textoLog = utf8_decode("Cadastro - Usuário: ".$cadLogin);
$logDAO->insertLog($textoLog);

  
