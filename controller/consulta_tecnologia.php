<?php

require_once ('../model/includes/inc.autoload.php');
require_once('verificaAcesso.php');

$tpl = new TemplatePower('../view/_MASTER.html');
$tpl->assignInclude('content','../view/consulta_tecnologia.html');


$tpl->prepare();

/****************************************************************************************************************************************************/

/* PAGINAÇÃO */

$total = new TecnologiaDAO();
$total = $total->getTotalEquip();

$pag = $_GET['pag'];

if($pag == ""){
	$pag = 1;
}
if($pag < 1){
	$pag = 1;
}

$max = 30;
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

/****** Fim Paginação *******/

/****** Grid Equipamentos ***/

$where = "";

if($_POST['frota']) {
	$where.= " AND TAB.PREFIXO LIKE '%".$_POST['frota']."%' ";
}

if($_POST['idEquip']) {
	$where.= " AND TAB.IDCCO LIKE '%".$_POST['idEquip']."%' ";
}

if($_POST['modelo']) {
	$where.= " AND TAB.MODELO LIKE '%".$_POST['modelo']."%' ";
}

/****************** PHPEXCEL ******************/
// Novo objeto PHPExcel
$objPHPExcel = new PHPExcel();

// Define as propriedades
$objPHPExcel->getProperties()->setCreator("TI - Henrique Stefani")
->setTitle("Tecnologia - Tecnologias Embarcadas - CCO - Stefani")
->setSubject("Tecnologia - Tecnologias Embarcadas")
->setDescription("Tecnologia - Tecnologias Embarcadas");

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
$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);	$objPHPExcel->getActiveSheet()->getStyle('L1')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setAutoSize(true);	$objPHPExcel->getActiveSheet()->getStyle('M1')->getFont()->setBold(true);
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', "ID Equipamento");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B1', "Modelo");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C1', "Tipo");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D1', "Frota");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E1', "Placa");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F1', "Marca");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G1', "Operação");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H1', "Filial");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I1', "Data de Instalação");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J1', "Tipo Frota");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('K1', "Situação");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('L1', "Medição");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('M1', "Fornecedor");

/****************** PHPEXCEL ******************/

$TecnologiaDAO = new TecnologiaDAO();
$TecnologiaDAO = $TecnologiaDAO->getDadosEquip($inicio, $final, $where);

if($TecnologiaDAO){
	foreach($TecnologiaDAO as $key => $value){
		
		$tech = $TecnologiaDAO[$key];
		
		$idTecnologia = $tech->idTecnologia;
		$idcco 		  = $tech->idcco; 
		$modelo 	  = $tech->modelo;
		$tipo 		  = $tech->tipo;
		$prefixo 	  =	$tech->prefixo; 
		$placa 		  = $tech->placa;
		$marca 		  = $tech->marca;
		$operacao     = $tech->operacao;
		$filial 	  = $tech->filial;
		$dtInstalacao = $tech->dtInstalacao;
		$tpFrota 	  = $tech->tpFrota;
		$situacao 	  = $tech->situacao;
		$fornecedor   = $tech->fornecedor;
		$medicao      = $tech->medicao;
		
		$tpl->newBlock('tech');

		$tpl->assign('idTecnologia',$idTecnologia);
		$tpl->assign('idcco',$idcco);
		$tpl->assign('modelo',$modelo);
		$tpl->assign('tipo',$tipo);
		$tpl->assign('prefixo',$prefixo);
		$tpl->assign('placa',$placa);
		$tpl->assign('marca',$marca);
		$tpl->assign('operacao',$operacao);
		$tpl->assign('filial',$filial);
		$tpl->assign('dtInstalacao',$dtInstalacao);
		$tpl->assign('tpFrota',$tpFrota);
		$tpl->assign('situacao',$situacao);
		$tpl->assign('medicao',$medicao);
		$tpl->assign('fornecedor',$fornecedor);
		
		$j = $key+1;
		
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$j, $idcco);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$j, $modelo);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$j, $tipo);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$j, $prefixo);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$j, $placa);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$j, $marca);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$j, $operacao);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$j, $filial);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$j, $dtInstalacao);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$j, $tpFrota);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.$j, $situacao);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('L'.$j, $medicao);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('M'.$j, $fornecedor);
	}
}

$rel = $_POST['btnrelatorio'];

if($rel){
	header('Content-Type: application/vnd.ms-excel');
	header("Content-Disposition: attachment; filename=tecnologias_embarcadas-tecnologia-".date("Ymd-His").".xls");
	header('Cache-Control: max-age=0');
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
	$objWriter->save('php://output');
}

if($_SESSION['nivel'] == 2){
	$tpl->newBlock('admin');
}

/****************************************************************************************************************************************************/

$tpl->printToScreen();