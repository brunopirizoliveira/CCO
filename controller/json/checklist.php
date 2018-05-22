<?php

require_once('../../model/includes/inc.autoload.php');

$mapa = new ChecklistDAO();

$response = $mapa->getDadosChecklist();
echo json_encode($response);
