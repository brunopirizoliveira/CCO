<?php

require_once('../../model/includes/inc.autoload.php');

$manut = new ManutencaoDAO();

$response = $manut->getDadosManutencao();

echo json_encode($response);