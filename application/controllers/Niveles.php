<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Niveles extends MY_Controller {        
    public function __construct() {
        parent::__construct();
    }
    public function index(){
        $data['tabTitle']       = "Plantilla Base - Niveles";
        $data['pagecontent']    = "niveles/niveles";
        $data['ninos']          = $this->Query_Model->DataNiveles();
        $data['data']           = $this->Query_Model->listarClasesAgendadas();
        
        $this->loadpageintotemplate($data);
   	}
    public function listarTodasClases(){
        $data = $this->Query_Model->listarClasesAgendadas();
        echo json_encode($data,JSON_UNESCAPED_UNICODE);
        die();
    }
}
