<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CalendarioMaestros extends MY_Controller {        
    public function __construct() {
        parent::__construct();
    }
    public function index(){
    	$user                        = $this->session->userdata('user');
        $data['tabTitle']            = "Plantilla Base - Calendario Maestros";
        $data['pagecontent']         = "CalendarioMaestros/calendarioMaestros";
        $data['calendariosmaestros'] = $this->Query_Model->GetMaestroByUser($user);
        $data['data']                = $this->Query_Model->GetDataFromMaestroByUser($user);
    
        $this->loadpageintotemplate($data);
   	}
    /* Registrar datos a la base de datos */
    public function registrar(){
        /* print_r($_POST); */
        if(empty($_POST['nombre_alumno']) || empty($_POST['hora_clase']) || empty($_POST['fecha_clase']) || empty($_POST['maestro']) || empty($_POST['nivel']) || empty($_POST['color'])){
            $mensaje = array('msg' => 'Todos los campos son requeridos', 'estado' => false, 'tipo' => 'warning');
        }else{
            $datos_alumno     = $_POST['nombre_alumno'];
            $datos_Aseparados = explode("|",$datos_alumno);
            $id_alumno        = $datos_Aseparados[0];
            $alumno           = $datos_Aseparados[1];

            $hora_clase  = $_POST['hora_clase'];
            $fecha_clase = $_POST['fecha_clase'];

            $datos_maestro      = $_POST['maestro'];
            $datos_Mseparados   = explode("|",$datos_maestro);
            $id_maestro         = $datos_Mseparados[0];
            $maestro            = $datos_Mseparados[1];

            $nivel = $_POST['nivel'];
            $color = $_POST['color'];
            $id    = $_POST['id'];

            if($id == ""){
                $datos_agenda_clase = array(
                    'id_nino'           => $id_alumno,
                    'nombre_alumno'     => $alumno,
                    'hora_clase'        => $hora_clase,
                    'fecha_clase'       => $fecha_clase,
                    'id_maestro'        => $id_maestro,
                    'nombre_maestro'    => $maestro,
                    'nivel_clase'       => $nivel,
                    'color'             => $color
                );

                $verificar = $this->Query_Model->checkClase($hora_clase,$fecha_clase,$id_maestro,$nivel);
                $data      = json_decode(json_encode($verificar), true);
                
                if(empty($data)){
                    $respuesta = $this->Query_Model->registrarClase($datos_agenda_clase);
                    if($respuesta == 1){
                        $mensaje = array('msg' => 'Clase registrada con exito', 'estado' => true, 'tipo' => 'success');
                    } else {
                        $mensaje = array('msg' => 'Error al registrar la clase', 'estado' => false, 'tipo' => 'error');
                    }
                }else{
                    if(($data[0]['hora_clase'] == $hora_clase) && ($data[0]['fecha_clase'] == $fecha_clase) && ($data[0]['id_maestro'] == $id_maestro) && ($data[0]['nivel_clase'] == $nivel)){
                        $mensaje = array('msg' => 'Ya no se encuentra disponible este horario, favor de elegir otro.', 'estado' => false, 'tipo' => 'warning');
                    }
                }
            } else {
                $datos_agenda_clase = array(
                    'id_nino'           => $id_alumno,
                    'nombre_alumno'     => $alumno,
                    'hora_clase'        => $hora_clase,
                    'fecha_clase'       => $fecha_clase,
                    'id_maestro'        => $id_maestro,
                    'nombre_maestro'    => $maestro,
                    'nivel_clase'       => $nivel,
                    'color'             => $color
                );

                $verificar = $this->Query_Model->checkClase($hora_clase,$fecha_clase,$id_maestro,$nivel);
                $data      = json_decode(json_encode($verificar), true);
                
                if(empty($data)){
                    $respuesta = $this->Query_Model->actualizarClase($id,$datos_agenda_clase);
                    if($respuesta == 1){
                        $mensaje = array('msg' => 'Clase actualizada con exito', 'estado' => true, 'tipo' => 'success');
                    } else {
                        $mensaje = array('msg' => 'Error al actualizar la clase', 'estado' => false, 'tipo' => 'error');
                    }
                }else{
                    if(($data[0]['hora_clase'] == $hora_clase) && ($data[0]['fecha_clase'] == $fecha_clase) && ($data[0]['id_maestro'] == $id_maestro) && ($data[0]['nivel_clase'] == $nivel)){
                        $mensaje = array('msg' => 'Ya no se encuentra disponible este horario, favor de elegir otro.', 'estado' => false, 'tipo' => 'warning');
                    }
                }
            }
            echo json_encode($mensaje);
            die();
        }
    }
    /* Eliminar el registro de la base de datos */
    public function eliminar($id){
        $data = $this->Query_Model->eliminarClase($id);
        if($data == 1){
            $mensaje = array('msg' => 'Clase cancelada con exito', 'estado' => true, 'tipo' => 'success');
        } else {
            $mensaje = array('msg' => 'Error al cancelar la clase', 'estado' => false, 'tipo' => 'error');
        }
        echo json_encode($mensaje,JSON_UNESCAPED_UNICODE);
        die();
    }
    /* Funci??n que permite que un dato del calendario sea desplazado a otro y se haga un update a la base de datos */
    public function drop(){
        $id         = $_POST['id'];
        $hora_clase = $_POST['hora'];
        $fecha      = $_POST['fecha'];
        $id_maestro = $_POST['id_maestro'];
        $nivel      = $_POST['nivel'];

        $datos_actualiza_clase = array(
            'fecha_clase'  => $fecha
        );

        $verificar = $this->Query_Model->checkClase($hora_clase,$fecha,$id_maestro,$nivel);
        $data      = json_decode(json_encode($verificar), true);
        
        if(empty($data)){
            $datos = $this->Query_Model->dropClase($id,$datos_actualiza_clase);
            if($datos == 1){
                $mensaje = array('msg' => 'Clase modificada con exito', 'estado' => true, 'tipo' => 'success');
            } else {
                $mensaje = array('msg' => 'Error al modificar la clase', 'estado' => false, 'tipo' => 'error');
            }
        }else{
            if(($data[0]['hora_clase'] == $hora_clase) && ($data[0]['fecha_clase'] == $fecha) && ($data[0]['id_maestro'] == $id_maestro) && ($data[0]['nivel_clase'] == $nivel)){
                $mensaje = array('msg' => 'Ya no se encuentra disponible este horario, favor de elegir otro.', 'estado' => false, 'tipo' => 'warning');
            }
        }
        echo json_encode($mensaje,JSON_UNESCAPED_UNICODE);
        die();
    }
    /* Obtener la informaci??n del maestro por el usuario */
    public function GetDataMaestroByUser(){
        $user = $this->session->userdata('user');
        $res  = $this->Query_Model->GetDataFromMaestroByUser($user);
        echo json_encode($res);
    }
    public function listarTodasClasesMaestro(){
        $user = $this->session->userdata('user');
        $data = $this->Query_Model->listarClasesAgendadasByMaestro($user);
        echo json_encode($data,JSON_UNESCAPED_UNICODE);
        die();
    }  
}
