<?php

require_once('inc.autoload.php');
require_once('inc.config.php');

Class FrotaDAO {

  private $dba;

  public function FrotaDAO() {

    $dba = new DbAdmin('oracle');
		$dba->connect(DBUSER,DBPASS,DBTNS);
		$this->dba = $dba;
  }

  public function buscaDadosFrota($frota) {

    $dba = $this->dba;

    $frota = str_pad($frota, 7, "0", STR_PAD_LEFT);

    $sqlv  = "SELECT COUNT(*) AS COUNT FROM HS_CT_FROTA H WHERE H.PREFIXO = '$frota' ";
    
    $stmt  = $dba->query($sqlv);
    $res   = oci_fetch_array($stmt, OCI_ASSOC);
    $count = $res['COUNT'];

    if($count == 0) {

      $sql = " SELECT  f.codigoempresa, 
                 f.codigofl, 
                 f.codigoga, 
                 f.placaatualveic as placa, 
                 t.descricaotpfrota as tpfrota, 
                 c.descricaoclassveic as operacao, 
                 m.descricaomarcarroc as marca
          FROM frt_cadveiculos f, 
               frt_tipodefrota t, 
               frt_classificacaoveic c, 
               frt_marcacarroc m
          WHERE f.codigotpfrota = t.codigotpfrota
                AND f.codigomodcarroc = m.codigomarcarroc
                AND f.codigoclassveic = c.codigoclassveic
                AND f.condicaoveic = 'A'
                AND f.prefixoveic = '".$frota."'";

      $stmt = $dba->query($sql);

      $response = new stdClass();

      while(OciFetchInto($stmt, $row, OCI_ASSOC)) {

        $response->empresa  = $row['CODIGOEMPRESA'];
        $response->filial   = $row['CODIGOFL'];
        $response->garagem  = $row['CODIGOGA'];
        $response->placa    = $row['PLACA'];
        $response->marca    = $row['MARCA'];
        $response->tpfrota  = $row['TPFROTA'];
        $response->operacao = $row['OPERACAO'];

      }
      return $response;
    
    } else {

      $response->frota = $frota;
      $response->bool = true;

      return $response;
    }

  }

  public function insertFrota($form) {

    $dba = $this->dba;

    parse_str($form);
    
	$frtPrefixo = str_pad($frtPrefixo, 7, "0", STR_PAD_LEFT);
    
    $sql = "INSERT INTO HS_CT_FROTA (IDFROTA,PLACA,SITUACAO,MARCA,PREFIXO,OPERACAO,TIPO,EMPRESA,FILIAL,GARAGEM,PROPRIETARIO,LOGIN,SENHA,TEMCONTRATO) 
            VALUES (seq_hs_ct_frota.NEXTVAL, '$frtPlaca', 'I', '$frtMarca', '$frtPrefixo', '$frtOperacao', '$frtTipo', '$frtEmpresa', '$frtFilial', '$frtGaragem', '$frtProprietario', '$frtLogin', '$frtSenha', '$temContrato')";

  if($dba->query($sql)) {

      $sqli = "SELECT seq_hs_ct_frota.currval as idfrota FROM dual";
      $stmt = $dba->query($sqli);
      $res = oci_fetch_array($stmt, OCI_ASSOC);
      $idFrota = $res['IDFROTA'];

      $response = new stdClass();

      $response->idFrota       = $idFrota;
      $response->dtInstalacao1 = $frtDtEquipamento1;
      $response->idTecnologia1 = $frtEquipIDTecnologia1;
      $response->dtInstalacao2 = $frtDtEquipamento2;
      $response->idTecnologia2 = $frtEquipIDTecnologia2;
      $response->dtInstalacao3 = $frtDtEquipamento3;
      $response->idTecnologia3 = $frtEquipIDTecnologia3;
    }
    
    return $response;
  }  
  
  public function buscaDadosFrotaEdita($frota){
	  
	  $dba = $this->dba;
	  
	  $sql = "SELECT    f.idfrota IDFROTA,
				  f.empresa EMPRESA,
				  f.filial FILIAL,
				  f.garagem GARAGEM,
				  f.marca MARCA,
				  f.operacao OPERACAO,
				  f.placa PLACA,
				  f.situacao SITUACAO,
				  f.tipo TPFROTA,
				  f.proprietario PROPRIETARIO,
				  f.login LOGIN,
				  f.senha SENHA,
				  f.temcontrato TEMCONTRATO
			 
		FROM      HS_CT_FROTA f
				  
		WHERE     f.prefixo = '$frota' ";
	  
	  $stmt = $dba->query($sql);
	  
	  $response = new stdClass();
	  
	  while(OciFetchInto($stmt, $row, OCI_ASSOC)){
		  $response->idfrota	  =	$row['IDFROTA'];
		  $response->empresa	  =	$row['EMPRESA'];
		  $response->filial		  =	$row['FILIAL'];
		  $response->garagem	  =	$row['GARAGEM'];
		  $response->marca		  =	$row['MARCA'];
		  $response->operacao	  =	$row['OPERACAO'];
		  $response->placa		  =	$row['PLACA'];
		  $response->situacao	  =	$row['SITUACAO'];
		  $response->tpfrota	  = $row['TPFROTA'];
		  $response->proprietario =	$row['PROPRIETARIO'];
		  $response->login		  =	$row['LOGIN'];
		  $response->senha		  =	$row['SENHA'];
		  $response->temContrato  = $row['TEMCONTRATO'];
	  }
	  
	  return $response;
	  
  }
  
  public function buscaDadosFrotaEquip($frota){
	  
	  $dba = $this->dba;
	  
	  $sql = "
		SELECT  t.idtecnologia IDTECNOLOGIA,
				t.idtecnologiaoriginal IDTECNOLOGIAORIGINAL,
				tm.descmedicao MEDICAO,
				tf.descricao FORNECEDOR,
				t.numeroantena NUMEQUIPAMENTO,
				t.datainstalacao INSTALACAO
		FROM    hs_ct_tecnologia t,
				hs_ct_frota f,
				hs_ct_tecnologia_medicao tm,
				hs_ct_tecnologia_fornecedor tf
		WHERE   t.idfrota = f.idfrota
		AND     t.idmedicao = tm.idmedicao
		AND     t.idfornecedor = tf.idfornecedor
		AND     t.in_frota = 'S'
		AND     f.prefixo = '$frota'
		";
	  
	  $stmt = $dba->query($sql);
	  
	  $i = 0;
	  while(OciFetchInto($stmt, $row, OCI_ASSOC)) {
	    $i = $i+1;	
		
		$idtecnologia	= $row['IDTECNOLOGIA'];
		$idtecnologiaoriginal = $row['IDTECNOLOGIAORIGINAL'];
        $medicao 		= $row['MEDICAO'];
	    $fornecedor		= $row['FORNECEDOR'];
	    $numequipamento	= $row['NUMEQUIPAMENTO'];
	    $instalacao		= $row['INSTALACAO'];

	    $frota = new Frota();
	  
		$frota->setIdTecnologia($idtecnologia);
		$frota->setIdTecnologiaOriginal($idtecnologiaoriginal);
		$frota->setMedicao($medicao);
		$frota->setFornecedor($fornecedor);
		$frota->setNumEquipamento($numequipamento);
		$frota->setInstalacao($instalacao);	  
	  
	    $vet[$i] = $frota;
      
	  
      }
	  
	  return $vet;
  }
  
  public function alteraSituacaoFrota($sit, $idFrt){
	  
	  $dba = $this->dba;
	  
	  $sql = "	UPDATE	HS_CT_FROTA
				SET		SITUACAO = '$sit'
				WHERE	IDFROTA = '$idFrt'";
				
	  $dba->query($sql);
	  
  }
  
      public function updateFrota($form, $idFrota){
	  
	  $dba = $this->dba;
	  
	  parse_str($form);
	  
	  $sql = "UPDATE HS_CT_FROTA SET PROPRIETARIO = '$frtProprietario', LOGIN = '$frtLogin', SENHA = '$frtSenha', TEMCONTRATO = '$temContrato' WHERE IDFROTA = '$idFrota'";
	  
	  $dba->query($sql);
	  
  }

}
