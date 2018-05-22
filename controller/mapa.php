<?php

require_once ('verificaAcesso.php');
require_once ('../model/includes/inc.autoload.php');
require_once ('../model/includes/inc.config.php');


$tpl = new TemplatePower('../view/_MASTER.html');
$tpl->assignInclude('content','../view/mapa.html');

$tpl->prepare();

/* ********************************************** */

/* PAGINAÇÃO */

$where = "";

$s = 0;

if($_POST['frota']) {
	$where.= " AND prefixo LIKE '%".$_POST['frota']."%' ";
	$s = 1;
}

if($_POST['placa']) {
	$where.= " AND placa 	 LIKE upper('%".$_POST['placa']."%') ";
	$s = 1;
}

if($_POST['filial']) { 
	$where .= " AND filial IN( '".$_POST['filial'][0]."'";
	for($i=1; $i<count($_POST['filial']); $i++) { 			 
		$where .= ",'".$_POST['filial'][$i]."'";	
	}
	$where .= ")";
	$s = 1;
}

if($_POST['operacao']) {
	$where .= " AND operacao IN( '".$_POST['operacao'][0]."'";
	for($i=1; $i<count($_POST['operacao']); $i++) { 			 
		$where .= ",'".$_POST['operacao'][$i]."'";	
	}
	$where .= ")";
	$s = 1;
}

if($_POST['tpFrota']) {
	$where .= " AND tipo IN( '".$_POST['tpFrota'][0]."'";
	for($i=1; $i<count($_POST['tpFrota']); $i++) { 			 
		$where .= ",'".$_POST['tpFrota'][$i]."'";	
	}
	$where .= ")";
	$s = 1;
}

$total = new MapaDAO();
$total = $total->getTotalMapa($where);

$pag = $_GET['pag'];

if($s==1){
	$max = $total;
}else{
	$max = 30;
}

if($pag == ""){
	$pag = 1;
}
if($pag < 1){
	$pag = 1;
}

$pgs = ceil($total / $max);

if($pag > $pgs){
	$pag = $pgs;
}

$inicio = $pag - 1;
$inicio = $inicio * $max;
$final = $inicio + $max;

$menos = $pag - 1; 
$mais = $pag + 1;   
$tpl->assign('pag',$pag);
$tpl->assign('pgs',$pgs);

if($total>0){
	if($total < $final){
		$msg = "Mostrando ".($inicio+1)." - ".$total." de ".$total;
	}else{
		$msg = "Mostrando ".($inicio+1)." - ".$final." de ".$total;
	}
}else{
	$msg = "Não existem registros";
}
$tpl->assign('mostrador',$msg);

if($pag > 1){
	$tpl->newBlock('start');
}

if($menos >= 1){
	$tpl->newBlock('back');
	$tpl->assign('menos',$menos);
}

if($mais <= $pgs){
	$tpl->newBlock('forward');
	$tpl->assign('mais',$mais);
}

if($pag < $pgs){
	$tpl->newBlock('end');
	$tpl->assign('pgs',$pgs);
}

/****************** PHPEXCEL ******************/
// Novo objeto PHPExcel
$objPHPExcel = new PHPExcel();

// Define as propriedades
$objPHPExcel->getProperties()->setCreator("TI - Henrique Stefani")
->setTitle("Frotas Ativos - Tecnologias Embarcadas - CCO - Stefani")
->setSubject("Frotas Ativos - Tecnologias Embarcadas")
->setDescription("Frotas Ativos - Tecnologias Embarcadas");

$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);	$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);	$objPHPExcel->getActiveSheet()->getStyle('B1')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);	$objPHPExcel->getActiveSheet()->getStyle('C1')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);	$objPHPExcel->getActiveSheet()->getStyle('D1')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);	$objPHPExcel->getActiveSheet()->getStyle('E1')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);	$objPHPExcel->getActiveSheet()->getStyle('F1')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);	$objPHPExcel->getActiveSheet()->getStyle('G1')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);	$objPHPExcel->getActiveSheet()->getStyle('H1')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);	$objPHPExcel->getActiveSheet()->getStyle('I1')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);	$objPHPExcel->getActiveSheet()->getStyle('J1')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);	$objPHPExcel->getActiveSheet()->getStyle('K1')->getFont()->setBold(true);
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', "Frota");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B1', "Placa");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C1', "Operação");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D1', "Filial");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E1', "Tipo");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F1', "Rastreador");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G1', "Nº Antena Rastreador");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H1', "Telemetria");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I1', "Nº Antena Telemetria");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J1', "Comunicação");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('K1', "Tem Contrato");

/****************** PHPEXCEL ******************/

/* Filtro FILIAL */
$FiltrosDAOP = new FiltrosDAO();
$FiltrosDAO = $FiltrosDAOP->lista('filial', 'A');

foreach($FiltrosDAO as $key => $value){
	
	$filial = $FiltrosDAO[$key];
	$filial = $filial->getFilial();
	$tpl->newBlock('filial');
	$tpl->assign('filial',$filial);
}

/* Filtro OPERAÇÃO */
$FiltrosDAO = $FiltrosDAOP->lista('operacao', 'A');

foreach($FiltrosDAO as $key => $value){
	
	$operacao = $FiltrosDAO[$key];
	$operacao = $operacao->getOperacao();
	$tpl->newBlock('operacao');
	$tpl->assign('operacao',$operacao);
}

/* Filtro TIPO */
$FiltrosDAO = $FiltrosDAOP->lista('tipo', 'A');

foreach($FiltrosDAO as $key => $value){
	
	$tipo = $FiltrosDAO[$key];
	$tipo = $tipo->getTpFrota();
	$tpl->newBlock('tipo');
	$tpl->assign('tipo',$tipo);
}

/* GRID MAPA */

$MapaDAO = new MapaDAO();
$MapaDAO = $MapaDAO->getDadosMapa($inicio, $final, $where);

if($MapaDAO){
	foreach($MapaDAO as $key => $value){
		
		$mapa = $MapaDAO[$key];
		
		$stGlobus			= $mapa->getStGlobus();
		$frota				= $mapa->getFrota();
		$placa				= $mapa->getPlaca();
		$operacao			= $mapa->getOperacao();
		$filial				= $mapa->getFilial();
		$tpFrota			= $mapa->getTipo();
		$rastreador			= $mapa->getRastreador();
		$telemetria			= $mapa->getTelemetria();
		$ambos 				= $mapa->getAmbos();
		$numAntenaRas		= $mapa->getNumAntenaRas();
		$numAntenaTel		= $mapa->getNumAntenaTel();
		$numAntenaAmb       = $mapa->getNumAntenaAmb();		
		$comunicacao		= $mapa->getComunicacao();
		$comunicacaoAmb		= $mapa->getComunicacaoAmb();
		$temcontrato		= $mapa->getTemContrato();
		
		// $stRastreador		= $mapa->getStRastreador();
		// $stManutRastreador 	= $mapa->getStManutRastreador();
		// $stTelemetria		= $mapa->getStTelemetria();
		// $stManutTelemetria 	= $mapa->getStManutTelemetria();
		
		$tpl->newBlock('mapa');

		$tpl->assign('idfrota',$frota);
		$tpl->assign('stGlobus',$stGlobus);
		$tpl->assign('frota',$frota);
		$tpl->assign('placa',$placa);
		$tpl->assign('operacao',$operacao);
		$tpl->assign('filial',$filial);
		$tpl->assign('tpFrota',$tpFrota);
		$tpl->assign('temContrato',$temcontrato);
		
		if($ambos) {			
			$tpl->assign('rastreador',$ambos);
			$tpl->assign('telemetria',$ambos);
			$tpl->assign('numAntenaRas',$numAntenaAmb);
			$tpl->assign('numAntenaTel',$numAntenaAmb);			
			$tpl->assign('comunicacao',$comunicacaoAmb);			
		} else {
			$tpl->assign('rastreador',$rastreador);
			$tpl->assign('numAntenaRas',$numAntenaRas);
			$tpl->assign('numAntenaTel',$numAntenaTel);
			$tpl->assign('telemetria',$telemetria);
			$tpl->assign('comunicacao',$comunicacao);
		}
		// $tpl->assign('stRastreador',$stRastreador);
		// $tpl->assign('stManutRastreador',$stManutRastreador);
		// $tpl->assign('stTelemetria',$stTelemetria);
		// $tpl->assign('stManutTelemetria',$stManutTelemetria);
			
		$j = $key+1;
		
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$j, $frota);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$j, $placa);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$j, $operacao);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$j, $filial);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$j, $tpFrota);

		if($ambos){
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$j, $ambos);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$j, $numAntenaAmb);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$j, $numAntenaAmb);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$j, $ambos);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$j, $comunicacaoAmb);
		}else{
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$j, $rastreador);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$j, $numAntenaRas);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$j, $numAntenaTel);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$j, $telemetria);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$j, $comunicacao);
		}
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.$j, $temcontrato);
			
	}
}

$relMapaDAO = new MapaDAO();
$relMapaDAO = $relMapaDAO->getDadosMapa(0, $total, $where);

if($relMapaDAO){
	foreach($relMapaDAO as $key => $value){
		
		$mapa = $relMapaDAO[$key];
		
		$stGlobus			= $mapa->getStGlobus();
		$frota				= $mapa->getFrota();
		$placa				= $mapa->getPlaca();
		$operacao			= $mapa->getOperacao();
		$filial				= $mapa->getFilial();
		$tpFrota			= $mapa->getTipo();
		$rastreador			= $mapa->getRastreador();
		$telemetria			= $mapa->getTelemetria();
		$ambos 				= $mapa->getAmbos();
		$numAntenaRas		= $mapa->getNumAntenaRas();
		$numAntenaTel		= $mapa->getNumAntenaTel();
		$numAntenaAmb       = $mapa->getNumAntenaAmb();		
		$comunicacao		= $mapa->getComunicacao();
		$comunicacaoAmb		= $mapa->getComunicacaoAmb();
		$temcontrato		= $mapa->getTemContrato();
			
		$j = $key+1;
		
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$j, $frota);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$j, $placa);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$j, $operacao);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$j, $filial);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$j, $tpFrota);

		if($ambos){
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$j, $ambos);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$j, $numAntenaAmb);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$j, $numAntenaAmb);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$j, $ambos);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$j, $comunicacaoAmb);
		}else{
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$j, $rastreador);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$j, $numAntenaRas);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$j, $numAntenaTel);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$j, $telemetria);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$j, $comunicacao);
		}
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.$j, $temcontrato);
		
		
	}
}

$rel = $_POST['btnrelatorio'];

if($rel){
	header('Content-Type: application/vnd.ms-excel');
	header("Content-Disposition: attachment; filename=tecnologias_embarcadas-ativos-".date("Ymd-His").".xls");
	header('Cache-Control: max-age=0');
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
	$objWriter->save('php://output');
}

if($_SESSION['nivel'] == 2){
	$tpl->newBlock('admin');
}

// $tpl->newBlock( "currentPage" );
// $tpl->assign( "page", "Mapa" );

$tpl->printToScreen();
