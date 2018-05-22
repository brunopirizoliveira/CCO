<?php

require_once ('../model/includes/inc.autoload.php');
require_once('verificaAcesso.php');

session_start();

$logDAO = new LogDAO();
$textoLog = utf8_decode("Usuário - Desconectou-se");

$logDAO->insertLog($textoLog);

session_destroy();
setcookie("cookname","", 1);
setcookie("cookpass","", 1);
header("Location: login.php");