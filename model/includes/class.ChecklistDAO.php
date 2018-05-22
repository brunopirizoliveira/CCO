<?php

require_once('inc.autoload.php');
require_once('inc.config.php');

Class ChecklistDAO {

  private $dba;

  public function ChecklistDAO() {

    $dba = new DbAdmin('oracle');
    $dba->connect(DBUSER,DBPASS,DBTNS);
    $this->dba = $dba;
  }

  public function getDadosChecklist($frota = null, $page = null, $rows = null, $sidx = null, $sord = null) {

    $response = new stdClass();
    $response->page = 1;
    $response->total = 1;
    $response->records = 1;
    $response->rows[0]['id'] = 1;
    $response->rows[0]['cell'] = array('numero' => '1', 'data' => '13/08/2015', 'arquivo' => 'cklst130815.xls');

    return $response;

  }

}
