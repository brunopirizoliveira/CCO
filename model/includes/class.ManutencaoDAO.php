<?php

Class ManutencaoDAO {
	
	private $dba;

	public function ManutencaoDAO() {

		$dba = new DbAdmin('oracle');
		$dba->connect(DBUSER,DBPASS,DBTNS);
		$this->dba = $dba;
	}

	public function getDadosManutencao() {

		$dba = $this->dba;

	    $response = new stdClass();

	    $page  = $_REQUEST['page'];
    	$limit = $_REQUEST['rows'];
    	$sidx  = $_REQUEST['sidx'] ? $_REQUEST['sidx'] : 1;
    	$sord  = $_REQUEST['sord'];


    	//Busca a quantidade de dados

    	$sqlCount = "SELECT COUNT(*) FROM HS_CT_MANUTENCAO M, HS_CT_MANUTENCAO_ITENS  I WHERE M.IDMANUTENCAO = I.IDMANUTENCAO"; //WHERE F.IDFROTA = M.IDFROTA AND M.IDFROTA = ".$idFrota; 


    	$stmtCount = $dba->query($sqlCount);
	    $resCount = oci_fetch_array($stmtCount, OCI_ASSOC);
	    $count = $resCount['COUNT(*)'];

	    if( $count >0 )
	    	$total_pages = ceil($count/$limit);
	    else
	    	$total_pages = 0;

	    $start = $limit*$page - $limit; 

	    $sql = "SELECT M.IDMANUTENCAO, 
				       M.DTABERTURAMANUT, 
				       M.NUMEROOS, 
				       M.STATUSOS, 
				       M.DTABERTURAOS, 
				       M.DATAAGENDAMENTO, 
				       M.LOCALATENDIMENTO, 
				       '' AS FOTO,
				       '' AS COMENTARIO,
				       I.ITEM AS PROBLEMA 
				FROM HS_CT_MANUTENCAO M, HS_CT_MANUTENCAO_ITENS I, HS_CT_MANUTENCAO_FOTOS F, HS_CT_MANUTENCAO_COMENTARIOS C 
				WHERE M.IDMANUTENCAO = I.IDMANUTENCAO 
				AND   M.IDMANUTENCAO = C.IDMANUTENCAO (+)
				AND   M.IDMANUTENCAO = F.IDMANUTENCAO (+)";

		$stmt = $dba->query($sql);				

	    $response->page = $page;
	    $response->total = $total_pages;
	    $response->records = $count;

	    $i = 0;
	    while(OciFetchInto($stmt, $row, OCI_ASSOC)) {

	    	$response->rows[$i]['id'] = $i;
	        $response->rows[$i]['cell'] = array(
	                                          'numero'         => $row['IDMANUTENCAO'],
	                                          'data'           => $row['DTABERTURAMANUT'],
	                                          'problema'       => $row['PROBLEMA'],
	                                          'dtAberturaOS'   => $row['DTABERTURAOS'],
	                                          'dtAgendamento'  => $row['DATAAGENDAMENTO'],
	                                          'local'          => $row['LOCALATENDIMENTO'],
	                                          'os'        	   => $row['NUMEROOS'],
	                                          'foto'           => $row['FOTO'],
	                                          'ultRegistro'    => $row['COMENTARIO']);                                          

	        $i++;
	    }	    

	    return $response;
	}
}