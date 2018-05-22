<?php

	require_once('../../model/includes/inc.autoload.php');

	$fornDAO = new FornecedorDAO();
	$response = $fornDAO->lista();
	
	echo json_encode($response);