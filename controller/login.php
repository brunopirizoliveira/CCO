<?php

require_once ('../model/includes/inc.autoload.php');

session_start();

if(isset($_COOKIE['cookname']) && isset($_COOKIE['cookpass'])){
  $_SESSION['user'] = $_COOKIE['cookname'];
  $_SESSION['pass'] = $_COOKIE['cookpass'];
  header("Location: login_execute.php");
}

$tpl = new TemplatePower('../view/_HOME.html');
$tpl->assignInclude('content','../view/login.html');

$tpl->prepare();

// $tpl->newBlock( "currentPage" );
// $tpl->assign( "page", "Mapa" );

$tpl->printToScreen();
