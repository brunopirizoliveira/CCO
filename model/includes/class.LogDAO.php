<?php

require_once('inc.autoload.php');
require_once('inc.config.php');

Class LogDAO {

  private $dba;

  public function LogDAO() {

    $dba = new DbAdmin('oracle');
	$dba->connect(DBUSER,DBPASS,DBTNS);
	$this->dba = $dba;
  }

  public function insertLog($textoLog) {

  	$dba = $this->dba;

  	$data 	  = date("d/m/Y");
  	$dataHora = date("H:i:s");

  	$sql = "INSERT INTO HS_CT_LOG (IDLOG, LOGIN, DATA, DATAHORA, TEXTOLOG, IPADRESS) 
  			VALUES (seq_hs_ct_log.nextval, '".$_SESSION['login']."', '".$data."', '".$dataHora."', '".$textoLog."', '".$_SERVER['REMOTE_ADDR']."')";

	$dba->query($sql);	
  }
  
  public function buscaLog($logUsuario = null, $logDtIni = null, $logDtFim = null){
	  
	$dba = $this->dba;
	
	$where = "";
	
	if($logUsuario){
		$where .= " AND L.LOGIN LIKE LOWER('%".$logUsuario."%') ";
	}
	if($logDtIni){
		$where .= " AND L.DATA >= '".$logDtIni."'";
	}
	if($logDtFim){
		$where .= " AND L.DATA <= '".$logDtFim."'";
	}
	
	
	$sql = "
		SELECT  DISTINCT
				L.IDLOG ID,
				L.LOGIN USUARIO,
				L.DATA DATALOG,
				L.DATAHORA DATAHORALOG,
				L.TEXTOLOG TEXTOLOG,
				L.IPADRESS ENDERECO 

		FROM    HS_CT_LOG L,
				HS_CT_USUARIO U
				
		WHERE   L.LOGIN = U.LOGIN
		-- INICIO WHERE
		$where
		-- FINAL WHERE

		ORDER BY L.IDLOG
		";
		
	$res = $dba->query($sql);
	
	$i = 0;

	while (OCIFetchInto($res, $row, OCI_ASSOC)){
				
		$i = $i+1;
							
		$usuario  	= $row['USUARIO'];
		$data	    = $row['DATALOG'];
		$datahora	= $row['DATAHORALOG'];
		$textoLog	= utf8_encode($row['TEXTOLOG']);
		$ipAdress	= $row['ENDERECO'];
		
		$log = new Log();
					
		$log->setUsuario($usuario);
		$log->setDataLog($data);
		$log->setDataHoraLog($datahora);
		$log->setTextoLog($textoLog);
		$log->setIpAdress($ipAdress);
					
		$vet[$i] = $log;
	}
				
		
	return $vet;
	  
  }


}