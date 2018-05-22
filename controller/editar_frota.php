<?php

require_once ('../model/includes/inc.autoload.php');
require_once('verificaAcesso.php');

$tpl = new TemplatePower('../view/_MASTER.html');
$tpl->assignInclude('content','../view/editar_frota.html');
// $tpl->assignInclude('aside','../view/checklist.html');

$tpl->prepare();

/**********************************************************************************************************************************************/

$frota = $_GET['frota'];

$edita = new FrotaDAO();
$responseFrota = $edita->buscaDadosFrotaEdita($frota);

$idfrota = $responseFrota->idfrota;
$empresa = $responseFrota->empresa;
$filial = $responseFrota->filial;
$garagem = $responseFrota->garagem;
$marca = $responseFrota->marca;
$operacao = $responseFrota->operacao;
$placa = $responseFrota->placa;
$situacao = $responseFrota->situacao;
$temcontrato = $responseFrota->temContrato;
$tpfrota = $responseFrota->tpfrota;
$proprietario = $responseFrota->proprietario;
$usuario = $responseFrota->login;
$senha = $responseFrota->senha;
$medicao = $responseFrota->medicao;
$fornecedor = $responseFrota->fornecedor;
$equipamento = $responseFrota->equipamento;
$numequipamento = $responseFrota->numequipamento;
$instalacao = $responseFrota->instalacao;

if($situacao == 'I'){
	$tpl->assign('in','in');
	$tpl->assign('ina','A');
	$tpl->assign('change','A');
}else{
	$tpl->assign('ina','Ina');
	$tpl->assign('change','I');
}

if($temcontrato == 'N') {	
	$tpl->assign('nao','checked');
} else if($temcontrato == 'S') {	
	$tpl->assign('sim','checked');
}

$tpl->assign('idfrota',$idfrota);
$tpl->assign('frota',$frota);
$tpl->assign('empresa',$empresa);
$tpl->assign('filial',$filial);
$tpl->assign('garagem',$garagem);
$tpl->assign('marca',$marca);
$tpl->assign('operacao',$operacao);
$tpl->assign('placa',$placa);
$tpl->assign('tpfrota',$tpfrota);
$tpl->assign('proprietario',$proprietario);
$tpl->assign('login',$usuario);
$tpl->assign('senha',$senha);


$responseEquip = $edita->buscaDadosFrotaEquip($frota);

if($responseEquip){
	foreach($responseEquip as $key => $value){
		
		$equip = $responseEquip[$key];
		
		$idtecnologia	= $equip->getIdTecnologia();
		$idtecnologiaoriginal = $equip->getIdTecnologiaOriginal();
		$medicao 		= $equip->getMedicao();
		$fornecedor 	= $equip->getFornecedor();
		$numequipamento = $equip->getNumEquipamento();
		$instalacao 	= $equip->getInstalacao();
		
		$tpl->newBlock('DadosEquipamento');
		
		$tpl->assign('row',$key);
		$tpl->assign('medicao',$medicao);
		$tpl->assign('fornecedor',$fornecedor);
		$tpl->assign('numequipamento',$numequipamento);
		$tpl->assign('instalacao',$instalacao);
		$tpl->assign('idtecnologia',$idtecnologia);
		$tpl->assign('idtecnologiaorg',$idtecnologiaoriginal);
	}
	
	
}else{
	$key = 0;
}

if($key < 3){
	$tpl->newBlock('adicionar');
	$tpl->assign('row',$key+1);
}



/*$fornDAO = new FornecedorDAO();
$fornDAO = $fornDAO->lista();

foreach($fornDAO as $key => $value){

	$forn = $fornDAO[$key];

	$idf		= $forn->getIdFornecedor();
	$fornecedor = $forn->getDescricao();

	$tpl->newBlock('fornecedor');

	$tpl->assign('idf',$idf);
	$tpl->assign('fornecedor',$fornecedor);

	$tpl->newBlock('fornecedor-telemetria');

	$tpl->assign('idf',$idf);
	$tpl->assign('fornecedor',$fornecedor);

}*/

/**********************************************************************************************************************************************/

if($_SESSION['nivel'] == 2){
	$tpl->newBlock('admin');
}

$tpl->printToScreen();
