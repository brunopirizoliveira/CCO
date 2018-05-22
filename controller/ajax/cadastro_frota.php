<?php

require_once ('../../model/includes/inc.autoload.php');

$funcs = array('buscaDadosFrota', 'buscaDadosEquipamento');

$action = $_REQUEST['action'];

if(in_array($action, $funcs)) {
  switch ($action) {
    case 'buscaDadosFrota':

      $frtDAO = new FrotaDAO();
      $response  = $frtDAO->buscaDadosFrota($_REQUEST['frota']);

      echo json_encode($response);

      break;

    case 'buscaDadosEquipamento':

      $fornecedor = $_REQUEST['fornecedor'];
      $medicao    = $_REQUEST['medicao'];

      $tecDAO = new TecnologiaDAO();
      $response = $tecDAO->buscaDadosEquipamento($fornecedor, $medicao);      

      echo json_encode($response);

      break;

    default:
      # code...
      break;
  }
}
