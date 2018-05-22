<?php

require_once ('../../model/includes/inc.autoload.php');

$funcs = array('buscaItensFrota');

$action = $_REQUEST['action'];

if(in_array($action, $funcs)) {
  switch ($action) {
    case 'buscaItensFrota':
    	
    		$itens = new ItensDeTecnologiaDAO();
    		$response = $itens->listaItensFrota();

    		echo json_encode($response);

      	break;

    default:
      # code...
      break;
  }
}
