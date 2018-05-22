<?php

require_once('inc.autoload.php');
require_once('inc.config.php');

Class MapaDAO {

  private $dba;

  public function MapaDAO() {

    $dba = new DbAdmin('oracle');
		$dba->connect(DBUSER,DBPASS,DBTNS);
		$this->dba = $dba;
  }

  // $page   get the requested page
  // $limit  get how many rows we want to have into the grid
  // $sidx   get index row - i.e. user click to sort
  // $sord   get the direction

  public function getDadosMapa($inicio, $final, $where) {
  
    $dba = $this->dba;
			  
	$sql = "SELECT 	*
			FROM 	(	SELECT	topn.*, ROWNUM rnum
						FROM 	( 	SELECT 	DISTINCT
											ROW_NUMBER() OVER (ORDER BY prefixo ASC) a, 
											tab.prefixo, tab.placa, tab.operacao, tab.tipo,
											tab.filial, tab.rastreador, tab.telemetria, tab.ambos,
											tab.temcontrato, tab.comunicacao, tab.comunicacaoAmb, 
											tab.numeroantenatelemetria, tab.numeroantenaambos,
											tab.numeroantenarastreador, tab.modelo  
									FROM	(	SELECT 	DISTINCT 
														f.prefixo, f.placa, f.operacao, f.tipo,
														f.filial, f.situacao, f.temcontrato,
														(	SELECT 	descricao 
															FROM 	hs_ct_tecnologia_fornecedor ff, hs_ct_tecnologia tt  
															WHERE 	ff.idfornecedor = tt.idfornecedor AND tt.idfrota = f.idfrota 
																AND tt.idmedicao = 2 AND tt.idtecnologia != tt.idtecnologiaoriginal 
																AND tt.in_frota ='S' AND ROWNUM='1'
														) AS rastreador,
														(	SELECT 	descricao 
															FROM 	hs_ct_tecnologia_fornecedor ff, hs_ct_tecnologia tt  
															WHERE 	ff.idfornecedor = tt.idfornecedor AND tt.idfrota = f.idfrota 
																AND tt.idmedicao = 1 AND tt.idtecnologia != tt.idtecnologiaoriginal 
																AND tt.in_frota ='S' AND ROWNUM='1'
														) AS telemetria,
														(	SELECT 	descricao 
															FROM 	hs_ct_tecnologia_fornecedor ff, hs_ct_tecnologia tt  
															WHERE 	ff.idfornecedor = tt.idfornecedor AND tt.idfrota = f.idfrota 
																AND tt.idmedicao = 3 AND tt.idtecnologia != tt.idtecnologiaoriginal 
																AND tt.in_frota ='S' AND ROWNUM='1'
														) AS ambos,
														(	SELECT 	tp.descricao 
															FROM 	hs_ct_tecnologia_tipo tp, hs_ct_tecnologia tt  
															WHERE 	tp.idtipo = tt.idtipo AND tt.idfrota = f.idfrota 
																AND tt.idmedicao=2 AND tt.idtecnologia != tt.idtecnologiaoriginal 
																AND tt.in_frota ='S' AND ROWNUM='1'
														) AS comunicacao,
														(	SELECT 	tp.descricao 
															FROM 	hs_ct_tecnologia_tipo tp, hs_ct_tecnologia tt  
															WHERE 	tp.idtipo = tt.idtipo AND tt.idfrota = f.idfrota 
																AND tt.idmedicao=3 AND tt.idtecnologia != tt.idtecnologiaoriginal 
																AND tt.in_frota ='S' AND ROWNUM='1'
														) AS comunicacaoAmb,
														(	SELECT 	tt.modelo 
															FROM 	hs_ct_tecnologia tt 
															WHERE 	tt.idfrota = f.idfrota AND tt.idmedicao=2 
																AND t.idtecnologia != t.idtecnologiaoriginal AND t.in_frota ='S' 
																AND ROWNUM='1'
														) AS modelo,
														(	SELECT 	tt.numeroantena 
															FROM 	hs_ct_tecnologia tt 
															WHERE 	tt.idmedicao=1 AND tt.idfrota = f.idfrota 
																AND tt.idtecnologia != tt.idtecnologiaoriginal AND t.in_frota ='S' 
																AND ROWNUM='1'
														) AS numeroantenatelemetria, 
														(	SELECT 	tt.numeroantena 
															FROM 	hs_ct_tecnologia tt 
															WHERE 	tt.idmedicao=2 AND tt.idfrota = f.idfrota 
																AND tt.idtecnologia != tt.idtecnologiaoriginal AND t.in_frota ='S' 
																AND ROWNUM='1'
														) AS numeroantenarastreador,
														(	SELECT 	tt.numeroantena 
															FROM 	hs_ct_tecnologia tt 
															WHERE 	tt.idmedicao=3 AND tt.idfrota = f.idfrota 
																AND tt.idtecnologia != tt.idtecnologiaoriginal AND t.in_frota ='S' 
																AND rownum='1'
														) AS numeroantenaambos
												FROM 	hs_ct_frota f        
												LEFT JOIN 	hs_ct_tecnologia t ON f.idfrota = t.idfrota 
													AND t.idtecnologia != t.idtecnologiaoriginal AND t.in_frota ='S'
												WHERE 	f.situacao = 'A'
													$where
												) tab
									ORDER BY 	PREFIXO ) topn
							  WHERE ROWNUM <= $final )
						WHERE rnum  > $inicio";
//VAR_DUMP($sql);die;
    $stmt = $dba->query($sql);
	
    $i = 0;
	
    while(OciFetchInto($stmt, $row, OCI_ASSOC)) {

	  $i = $i+1;	
		
      $stGlobus 			= $row['STGLOBUS'];
	  $frota				= $row['PREFIXO'];
	  $placa				= $row['PLACA'];
	  $operacao				= $row['OPERACAO'];
	  $filial				= $row['FILIAL'];
	  $tipo					= $row['TIPO'];
	  $rastreador			= $row['RASTREADOR'];
	  $numAntenaTel 		= $row['NUMEROANTENATELEMETRIA'];
	  $numAntenaRas 		= $row['NUMEROANTENARASTREADOR'];
	  $numAntenaAmb  		= $row['NUMEROANTENAAMBOS'];
	  $telemetria			= $row['TELEMETRIA'];
	  $ambos				= $row['AMBOS'];
	  $comunicacao			= $row['COMUNICACAO'];
	  $comunicacaoAmb 		= $row['COMUNICACAOAMB'];
	  $temcontrato          = $row['TEMCONTRATO'];
	  // $stRastreador			= $row['STRASTREADOR'];
	  // $stManutRastreador		= $row['STMANUTRASTREADOR'];
	  // $stTelemetria			= $row['STTELEMETRIA'];
      // $stManutTelemetria		= $row['STMANUTTELEMETRIA'];

	  $mapa = new Mapa();
	  
	  $mapa->setStGlobus($stGlobus);
	  $mapa->setFrota($frota);
	  $mapa->setPlaca($placa);
	  $mapa->setOperacao($operacao);
	  $mapa->setFilial($filial);
	  $mapa->setTipo($tipo);
	  $mapa->setRastreador($rastreador);
	  $mapa->setAmbos($ambos);
	  $mapa->setNumAntenaRas($numAntenaRas);
	  $mapa->setNumAntenaTel($numAntenaTel);
	  $mapa->setNumAntenaAmb($numAntenaAmb);
	  $mapa->setTelemetria($telemetria);
	  $mapa->setComunicacao($comunicacao);
	  $mapa->setComunicacaoAmb($comunicacaoAmb);
	  $mapa->setTemContrato($temcontrato);
	  // $mapa->setStRastreador($stRastreador);
	  // $mapa->setStManutRastreador($stManutRastreador);
	  // $mapa->setStTelemetria($stTelemetria);
	  // $mapa->setStManutTelemetria($stManutTelemetria);
	  
	  
	  $vet[$i] = $mapa;      
	  
    }
	  return $vet;
	
  }


  public function getDadosMapaInativos($inicio, $final, $where) {
// var_dump($where);
    $dba = $this->dba;
				
	$sql = "SELECT 	*
			FROM 	(	SELECT	topn.*, ROWNUM rnum
						FROM 	( 	SELECT 	DISTINCT
											ROW_NUMBER() OVER (ORDER BY prefixo ASC) a, 
											tab.prefixo, tab.placa, tab.operacao, tab.tipo,
											tab.filial, tab.rastreador, tab.telemetria, tab.ambos,
											tab.temcontrato, tab.comunicacao, tab.comunicacaoAmb, 
											tab.numeroantenatelemetria, tab.numeroantenaambos,
											tab.numeroantenarastreador, tab.modelo  
									FROM	(	SELECT 	DISTINCT 
														f.prefixo, f.placa, f.operacao, f.tipo,
														f.filial, f.situacao, f.temcontrato,
														(	SELECT 	descricao 
															FROM 	hs_ct_tecnologia_fornecedor ff, hs_ct_tecnologia tt  
															WHERE 	ff.idfornecedor = tt.idfornecedor AND tt.idfrota = f.idfrota 
																AND tt.idmedicao = 2 AND tt.idtecnologia != tt.idtecnologiaoriginal 
																AND tt.in_frota ='S' AND ROWNUM='1'
														) AS rastreador,
														(	SELECT 	descricao 
															FROM 	hs_ct_tecnologia_fornecedor ff, hs_ct_tecnologia tt  
															WHERE 	ff.idfornecedor = tt.idfornecedor AND tt.idfrota = f.idfrota 
																AND tt.idmedicao = 1 AND tt.idtecnologia != tt.idtecnologiaoriginal 
																AND tt.in_frota ='S' AND ROWNUM='1'
														) AS telemetria,
														(	SELECT 	descricao 
															FROM 	hs_ct_tecnologia_fornecedor ff, hs_ct_tecnologia tt  
															WHERE 	ff.idfornecedor = tt.idfornecedor AND tt.idfrota = f.idfrota 
																AND tt.idmedicao = 3 AND tt.idtecnologia != tt.idtecnologiaoriginal 
																AND tt.in_frota ='S' AND ROWNUM='1'
														) AS ambos,
														(	SELECT 	tp.descricao 
															FROM 	hs_ct_tecnologia_tipo tp, hs_ct_tecnologia tt  
															WHERE 	tp.idtipo = tt.idtipo AND tt.idfrota = f.idfrota 
																AND tt.idmedicao=2 AND tt.idtecnologia != tt.idtecnologiaoriginal 
																AND tt.in_frota ='S' AND ROWNUM='1'
														) AS comunicacao,
														(	SELECT 	tp.descricao 
															FROM 	hs_ct_tecnologia_tipo tp, hs_ct_tecnologia tt  
															WHERE 	tp.idtipo = tt.idtipo AND tt.idfrota = f.idfrota 
																AND tt.idmedicao=3 AND tt.idtecnologia != tt.idtecnologiaoriginal 
																AND tt.in_frota ='S' AND ROWNUM='1'
														) AS comunicacaoAmb,
														(	SELECT 	tt.modelo 
															FROM 	hs_ct_tecnologia tt 
															WHERE 	tt.idfrota = f.idfrota AND tt.idmedicao=2 
																AND t.idtecnologia != t.idtecnologiaoriginal AND t.in_frota ='S' 
																AND ROWNUM='1'
														) AS modelo,
														(	SELECT 	tt.numeroantena 
															FROM 	hs_ct_tecnologia tt 
															WHERE 	tt.idmedicao=1 AND tt.idfrota = f.idfrota 
																AND tt.idtecnologia != tt.idtecnologiaoriginal AND t.in_frota ='S' 
																AND ROWNUM='1'
														) AS numeroantenatelemetria, 
														(	SELECT 	tt.numeroantena 
															FROM 	hs_ct_tecnologia tt 
															WHERE 	tt.idmedicao=2 AND tt.idfrota = f.idfrota 
																AND tt.idtecnologia != tt.idtecnologiaoriginal AND t.in_frota ='S' 
																AND ROWNUM='1'
														) AS numeroantenarastreador,
														(	SELECT 	tt.numeroantena 
															FROM 	hs_ct_tecnologia tt 
															WHERE 	tt.idmedicao=3 AND tt.idfrota = f.idfrota 
																AND tt.idtecnologia != tt.idtecnologiaoriginal AND t.in_frota ='S' 
																AND rownum='1'
														) AS numeroantenaambos
												FROM 	hs_ct_frota f        
												LEFT JOIN 	hs_ct_tecnologia t ON f.idfrota = t.idfrota 
													AND t.idtecnologia != t.idtecnologiaoriginal AND t.in_frota ='S'
												WHERE 	f.situacao = 'I'
													$where
												) tab
									ORDER BY 	PREFIXO ) topn
							  WHERE ROWNUM <= $final )
						WHERE rnum  > $inicio";
// var_dump($sql);die;
    $stmt = $dba->query($sql);
	
    $i = 0;

    while(OciFetchInto($stmt, $row, OCI_ASSOC)) {

	  $i = $i+1;	
		
      $stGlobus 			= $row['STGLOBUS'];
	  $frota				= $row['PREFIXO'];
	  $placa				= $row['PLACA'];
	  $operacao				= $row['OPERACAO'];
	  $filial				= $row['FILIAL'];
	  $tipo					= $row['TIPO'];
	  $rastreador			= $row['RASTREADOR'];
	  $numAntenaTel 		= $row['NUMEROANTENATELEMETRIA'];
	  $numAntenaRas 		= $row['NUMEROANTENARASTREADOR'];
	  $numAntenaAmb  		= $row['NUMEROANTENAAMBOS'];
	  $telemetria			= $row['TELEMETRIA'];
	  $ambos				= $row['AMBOS'];
	  $comunicacao			= $row['COMUNICACAO'];
	  $comunicacaoAmb 		= $row['COMUNICACAOAMB'];
	  $temcontrato          = $row['TEMCONTRATO'];
	  // $stRastreador			= $row['STRASTREADOR'];
	  // $stManutRastreador		= $row['STMANUTRASTREADOR'];
	  // $stTelemetria			= $row['STTELEMETRIA'];
      // $stManutTelemetria		= $row['STMANUTTELEMETRIA'];

	  $mapa = new Mapa();
	  
	  $mapa->setStGlobus($stGlobus);
	  $mapa->setFrota($frota);
	  $mapa->setPlaca($placa);
	  $mapa->setOperacao($operacao);
	  $mapa->setFilial($filial);
	  $mapa->setTipo($tipo);
	  $mapa->setRastreador($rastreador);
	  $mapa->setAmbos($ambos);
	  $mapa->setNumAntenaRas($numAntenaRas);
	  $mapa->setNumAntenaTel($numAntenaTel);
	  $mapa->setNumAntenaAmb($numAntenaAmb);
	  $mapa->setTelemetria($telemetria);
	  $mapa->setComunicacao($comunicacao);
	  $mapa->setComunicacaoAmb($comunicacaoAmb);
	  $mapa->setTemContrato($temcontrato);
	  // $mapa->setStRastreador($stRastreador);
	  // $mapa->setStManutRastreador($stManutRastreador);
	  // $mapa->setStTelemetria($stTelemetria);
	  // $mapa->setStManutTelemetria($stManutTelemetria);
	  
	  
	  $vet[$i] = $mapa;  
	  
    }
	  return $vet;
	
  }

  
  public function getTotalMapa($where){

		$dba = $this->dba;	
			
		$sql = "SELECT 	*
				FROM 	(	SELECT	topn.*, ROWNUM rnum
							FROM 	( 	SELECT 	DISTINCT
												ROW_NUMBER() OVER (ORDER BY prefixo ASC) a
												 
										FROM	(	SELECT 	DISTINCT 
															f.prefixo, f.placa, f.operacao, f.tipo,
															f.filial, f.situacao, f.temcontrato
															
												
                          FROM   hs_ct_frota f        
                          LEFT JOIN   hs_ct_tecnologia t ON f.idfrota = t.idfrota 
                            AND t.idtecnologia != t.idtecnologiaoriginal AND t.in_frota ='S'
                          WHERE   f.situacao = 'A'
                            $where
                          ) tab
                     ) 	topn
						ORDER BY RNUM
                  )";
		
//VAR_DUMP($sql);die;
		$res = $dba->query($sql);

		$i = 0;

			while (OCIFetchInto($res, $row, OCI_ASSOC)){
		
				$i = $i+1;
						
				$qtd  = $row['RNUM'];					
				
			}
				
		if(!$qtd){
			$qtd = 0;
		}
		return $qtd;
		
	}


	  public function getTotalMapaInativos($where){
// var_dump($where);die;
		$dba = $this->dba;	
				
		$sql = "SELECT 	*
				FROM 	(	SELECT	topn.*, ROWNUM rnum
							FROM 	( 	SELECT 	DISTINCT
												ROW_NUMBER() OVER (ORDER BY prefixo ASC) a
												 
										FROM	(	SELECT 	DISTINCT 
															f.prefixo, f.placa, f.operacao, f.tipo,
															f.filial, f.situacao, f.temcontrato
															
												
                          FROM   hs_ct_frota f        
                          LEFT JOIN   hs_ct_tecnologia t ON f.idfrota = t.idfrota 
                            AND t.idtecnologia != t.idtecnologiaoriginal AND t.in_frota ='S'
                          WHERE   f.situacao = 'I'
                            $where
                          ) tab
                     ) 	topn
						ORDER BY RNUM
                  )";

			
		$res = $dba->query($sql);

		$i = 0;

			while (OCIFetchInto($res, $row, OCI_ASSOC)){
		
				$i = $i+1;
							
				$qtd  = $row['RNUM'];							
			}
		if(!$qtd){
			$qtd = 0;
		}
		return $qtd;
		return $qtd;
	}



}
