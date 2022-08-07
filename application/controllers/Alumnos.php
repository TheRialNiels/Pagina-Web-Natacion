<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Alumnos extends MY_Controller {        
    public function __construct() {
        parent::__construct();
    }
    public function index(){
        $data['tabTitle']    = "Registro de Alumnos";
        $data['pagecontent'] = "alumnos/alumnos";
        $data['ninos']       = $this->Query_Model->DataNinos();
        $data['padres']      = $this->Query_Model->DataPadresActivos();
        
        $this->loadpageintotemplate($data);       
    }
    /* Guardar Alumno */
    public function SaveAlumno(){        
        $nombre         = $this->input->post("nombre");
        $apaterno       = $this->input->post("apaterno");
        $amaterno       = $this->input->post("amaterno");
        $tel_emergencia = $this->input->post("tel_emergencia");
        $nivel          = $this->input->post("nivel");

        $datos_alumno_tb_ninos = array(
            'nombre_nino'    => $nombre,
            'apaterno_nino'  => $apaterno,
            'amaterno_nino'  => $amaterno,
            'tel_emergencia' => $tel_emergencia,
            'nivel'          => $nivel,
            'role_nino'      => 'Nino',
            'estado_nino'    => '1'
        );
    
        $this->Query_Model->InsertAlumnoInTbNinos($datos_alumno_tb_ninos);
    }
    /* Actualizar Alumno */
    public function UpdateAlumno(){ 
        $id             = $this->input->post('id');
        $nombre         = $this->input->post("nombre");
        $apaterno       = $this->input->post("apaterno");
        $amaterno       = $this->input->post("amaterno");
        $tel_emergencia = $this->input->post("tel_emergencia");
        $nivel          = $this->input->post("nivel");
        $estado         = $this->input->post("estado");
        $padre          = $this->input->post("padre");

        $datos_alumno_tb_ninos = array(
            'nombre_nino'    => $nombre,
            'apaterno_nino'  => $apaterno,
            'amaterno_nino'  => $amaterno,
            'tel_emergencia' => $tel_emergencia,
            'nivel'          => $nivel,
            'estado_nino'    => $estado,
            'id_padre'       => $padre
        );
        $datos_alumno_tb_padres = array(
            'id_nino' => $id
        );
    
        $this->Query_Model->UpdateAlumnoInTbNinos($id,$datos_alumno_tb_ninos);
        if($padre == "0"){
            $this->Query_Model->UpdateAlumno2InTbPadres($id,0);
        }else {
            $this->Query_Model->UpdateAlumnoInTbPadres($padre,$datos_alumno_tb_padres);
        }    
    }
    /* Borrar Alumno */
    public function DeleteAlumno(){
        $id = $this->input->post('id');

        $datosalumno = array(
            'estado_nino' => 0
        );
        $datospadre = array(
            'id_nino' => 0
        );

        $this->Query_Model->DeleteAlumnoTbNinos($id,$datosalumno);
        $this->Query_Model->DeleteAlumnoFromTbPadres($id,$datospadre);
        redirect('/Padres');
    }
    /* Obtener el alumno mediante el ID asignado */
    public function AlumnoPorId(){
        $id  = $this->input->post('id');
        $res = $this->Query_Model->GetAlumnoById($id);
        echo json_encode($res);
    }
    /* Verificar si el padre ya se encuentra en la base de datos */
    function CheckPadreExistente(){
        $nino = $this->input->post("id_nino");
        $id   = $this->input->post("id_padre");
        $res  = array();

        $res['nino']  = $this->Query_Model->GetNinoById($nino);
        $res['padre'] = $this->Query_Model->GetPadreByIdNino($id);
        echo json_encode($res);
    }
}
