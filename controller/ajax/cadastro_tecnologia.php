<?php

require_once ('../../model/includes/inc.autoload.php');
require_once('../../controller/verificaAcesso.php');

$funcs = array('insereTecnologia');

$action = $_REQUEST['action'];

if(in_array($action, $funcs)) {
  switch ($action) {
    case 'insereTecnologia':
	
	  $logDAO = new LogDAO();
	
      if($_REQUEST['idTecno']) {
		  
		$idTecnologia = $_REQUEST['idTecno'];

        $tecDAO = new TecnologiaDAO();

        $bool = $tecDAO->updateTecnologia($_REQUEST['medicao'], $_REQUEST['idcco'], $_REQUEST['numAntena'], $_REQUEST['serial'], $_REQUEST['fornecedor'], $_REQUEST['modelo'], $_REQUEST['tipo'], $_REQUEST['idTecno'] );
		
        if($bool) {
          
          $boolKit = $tecDAO->deleteKit($_REQUEST['idTecno']);

          if($boolKit) {

            $retorno = array('sucesso');

            array_push($retorno, $tecDAO->insertKit($_REQUEST['idTecno'], $_REQUEST['sensor'], 1));
            array_push($retorno, $tecDAO->insertKit($_REQUEST['idTecno'], $_REQUEST['avisos'], 2));
            array_push($retorno, $tecDAO->insertKit($_REQUEST['idTecno'], $_REQUEST['comunicacao'], 3));
            array_push($retorno, $tecDAO->insertKit($_REQUEST['idTecno'], $_REQUEST['atuador'], 4));
            array_push($retorno, $tecDAO->insertKit($_REQUEST['idTecno'], $_REQUEST['sinal'], 5));

            if(in_array('erro', $retorno))
              echo 'Erro na atualização!!!';
            else
              echo 'Atualizado com sucesso!!!';      
		  
            $textoLog = utf8_decode("Alteração - Tecnologia: ".$idTecnologia." | KIT");
            $logDAO->insertLog($textoLog);
			
		  if($_REQUEST['idcco'] != $_REQUEST['idccoant']){
			  $textoLog = utf8_decode("Alteração - Tecnologia: ".$idTecnologia." | ID CCO: ".$_REQUEST['idcco']);
              $logDAO->insertLog($textoLog);
		  }
		  if($_REQUEST['numAntena'] != $_REQUEST['numAntenaant']){
			  $textoLog = utf8_decode("Alteração - Tecnologia: ".$idTecnologia." | Num Antena: ".$_REQUEST['numAntena']);
              $logDAO->insertLog($textoLog);
		  }
		  if($_REQUEST['modelo'] != $_REQUEST['modeloant']){
			  $textoLog = utf8_decode("Alteração - Tecnologia: ".$idTecnologia." | Modelo: ".$_REQUEST['modelo']);
              $logDAO->insertLog($textoLog);
		  }
		  if($_REQUEST['serial'] != $_REQUEST['serialant']){
			  $textoLog = utf8_decode("Alteração - Tecnologia: ".$idTecnologia." | Serial: ".$_REQUEST['serial']);
			  $logDAO->insertLog($textoLog);
		  }

          } else {
            echo 'Erro na atualização!!!';
          }

        }

      } else {

        $tecDAO = new TecnologiaDAO();
        
        $idTecnologia = $tecDAO->insertTecnologia($_REQUEST['medicao'], $_REQUEST['idcco'], $_REQUEST['numAntena'], $_REQUEST['serial'], $_REQUEST['fornecedor'], $_REQUEST['modelo'], $_REQUEST['tipo'] );
                                                                                                                                            
        $retorno = array('sucesso');

        if($idTecnologia) {

          array_push($retorno, $tecDAO->insertKit($idTecnologia, $_REQUEST['sensor'], 1));
          array_push($retorno, $tecDAO->insertKit($idTecnologia, $_REQUEST['avisos'], 2));
          array_push($retorno, $tecDAO->insertKit($idTecnologia, $_REQUEST['comunicacao'], 3));
          array_push($retorno, $tecDAO->insertKit($idTecnologia, $_REQUEST['atuador'], 4));
          array_push($retorno, $tecDAO->insertKit($idTecnologia, $_REQUEST['sinal'], 5));

          if(in_array('erro', $retorno))
            echo 'Erro na inclusão!!!';
          else
            echo 'Incluído com sucesso!!!';      

          $textoLog = utf8_decode("Cadastro - Tecnologia: ".$idTecnologia);
          
          $logDAO->insertLog($textoLog);

        } else {
            echo 'Erro na inclusão!!!';
        }

      }

      break;

    default:
      # code...
      break;
  }
}
