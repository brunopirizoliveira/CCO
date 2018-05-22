<?php

require_once('inc.autoload.php');
require_once('inc.config.php');

Class UsuarioDAO {

  private $dba;

  public function UsuarioDAO() {

    $dba = new DbAdmin('oracle');
	$dba->connect(DBUSER,DBPASS,DBTNS);
	$this->dba = $dba;
	
  }

  public function buscaLogin($user, $pass) {

  	$dba = $this->dba;

  	$sql = "SELECT * FROM HS_CT_USUARIO WHERE LOGIN = '".$user."' AND PASSWORD = '".md5($pass)."'";

  	$stmt = $dba->query($sql);

  	$response = new stdClass();

  	while(OciFetchInto($stmt, $row, OCI_ASSOC)) {

  		$response->id	 = $row['ID'];
  		$response->login = $row['LOGIN'];
		$response->nvlacesso = $row['NVLACESSO'];
  	}

  	return $response;
  }
  
  public function cadastraUsuario($cadNome, $cadEmpresa, $cadLogin, $cadSenha, $cadNvlAcesso){
	  
	  $dba = $this->dba;
	  
	  $sit = 'N';
	  
	  $sql = "INSERT INTO HS_CT_USUARIO (ID, EMPRESA, USUARIO, LOGIN, PASSWORD, NVLACESSO)
			  VALUES (SEQ_HS_CT_USUARIO.NEXTVAL, '".$cadEmpresa."', '".$cadNome."', '".$cadLogin."', '".md5($cadSenha)."', '".$cadNvlAcesso."')";
			  
	  if($dba->query($sql)){
		  $sit = 'S';
	  }
	  
	  return $sit;
	  
  }

}





















