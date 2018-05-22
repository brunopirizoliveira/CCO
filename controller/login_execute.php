<?php

require_once ('../model/includes/inc.autoload.php');

//COOKIES///////////////////////////////////////////////////

session_start();

date_default_timezone_set("America/Sao_Paulo");
$valor = "Hora de criação ". date("H:i:s");
$tempo = time() + 10800;
setcookie("cookie", $valor, $tempo);

if($_POST['lembrar'] == "1"){
	$_SESSION['user'] = $_POST['user'];
	$_SESSION['pass'] = $_POST['pass'];
	setcookie("cookname", $_SESSION['user'], time()+60*60*24*100);
	setcookie("cookpass", $_SESSION['pass'], time()+60*60*24*100);
}


////////////////////////////////////////////////////////////

if(isset($_POST['user']) && isset($_POST['pass'])) {

	$user = $_POST['user'];
	$pass = $_POST['pass'];

} else {

	header('Location: login.php');
}

$usuarioDAO = new UsuarioDAO();

$response = $usuarioDAO->buscaLogin($user, $pass);

if(isset($response->login) && $response->nvlacesso != 0) {

//	session_start();
	
	$tempoAtual = time();

	$_SESSION['login'] = $response->login;
	$_SESSION['id']    = $response->id;
	$_SESSION['nivel'] = $response->nvlacesso;
	$_SESSION['time']  = $tempoAtual;

	$logDAO = new LogDAO();
	$textoLog = utf8_decode("Usuário - Conectou-se");

	$logDAO->insertLog($textoLog);
													
	header('Location: mapa.php');

} else {	

	unset($_SESSION['login']);
	header('Location: login.php');	

}