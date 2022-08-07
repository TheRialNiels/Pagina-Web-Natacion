<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reportes extends MY_Controller{
  public function __construct() {
      parent::__construct();
  }
  /* Obtener data de los padres activos en la base de datos */
  public function PadresActivos(){
    $res = $this->Query_Model->PadresByEstatus();
    echo json_encode($res);
  }
  /* Obtener data de los alumnos activos en la base de datos */
  public function AlumnosActivos(){
    $res = $this->Query_Model->AlumnosByEstatus();
    echo json_encode($res);
  }
  /* Obtener data de los maestros activos en la base de datos */
  public function MaestrosActivos(){
    $res = $this->Query_Model->MaestrosByEstatus();
    echo json_encode($res);
  }
  /* Obtener data de los alumnos de todos los niveles activos en la base de datos */
  public function NivelesActivos(){
    $res = $this->Query_Model->NivelesByEstatus();
    echo json_encode($res);
  }
  /* Obtener data de los alumnos de nivel 1 activos en la base de datos */
  public function Nivel1Activos(){
    $res = $this->Query_Model->Nivel1ByEstatus();
    echo json_encode($res);
  }
  /* Obtener data de los alumnos de nivel 2 activos en la base de datos */
  public function Nivel2Activos(){
    $res = $this->Query_Model->Nivel2ByEstatus();
    echo json_encode($res);
  }
  /* Obtener data de los alumnos de nivel 3 activos en la base de datos */
  public function Nivel3Activos(){
    $res = $this->Query_Model->Nivel3ByEstatus();
    echo json_encode($res);
  }
}
?>
