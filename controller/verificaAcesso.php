<?php

session_start();

if(isset($_COOKIE['cookname']) && isset($_COOKIE['cookpass'])){
  $_SESSION['user'] = $_COOKIE['cookname'];
  $_SESSION['pass'] = $_COOKIE['cookpass'];
}

/*if(!isset($_COOKIE['cookie'])){
	if(isset($_SESSION['login'])){
		session_start();
		session_destroy(); 
		header("Location: login.php");
	}
}*/


$tempoAtual = time();
    	
if(empty($_SESSION['login']) || ($tempoAtual - $_SESSION['time']) > '6000'){
        
	session_destroy(); 
    header("Location: login.php");
	
}else if(!empty($_SESSION['login']) && ($tempoAtual - $_SESSION['time']) < '6000'){
		$_SESSION['time'] = $tempoAtual;
}