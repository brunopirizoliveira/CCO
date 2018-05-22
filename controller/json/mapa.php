<?php

require_once('../../model/includes/inc.autoload.php');

$mapa = new MapaDAO();

$response = $mapa->getDadosMapa();
echo json_encode($response);
