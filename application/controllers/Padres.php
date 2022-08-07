<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Padres extends MY_Controller {        
    public function __construct() {
        parent::__construct();
    }
    public function index(){
        $data['tabTitle']    = "Registro de Padres";
        $data['pagecontent'] = "padres/padres";
        $data['padres']      = $this->Query_Model->DataPadres();
        $data['ninos']       = $this->Query_Model->DataNinosActivos();
        
        $this->loadpageintotemplate($data);       
    }
    /* Verificar si el usuario ya existe en la BD para evitar que se repitan */
    function CheckUsuarioExistente(){
        $usuario = $this->input->post("username");
        $res     = $this->Query_Model->GetPadreByUsername($usuario);
        echo json_encode($res);
    }
    /* Verificar si el telefono ya existe en la BD para evitar que se repitan */
    function CheckTelefonoExistente(){
        $telefono = $this->input->post("telefono");
        $padre    = $this->input->post("id_padre");
        $maestro  = $this->input->post("id_maestro");
        if ($padre != "0"){
            $res['telefonoP'] = $this->Query_Model->GetPadreByTelefono($telefono);
            $res['telefonoM'] = $this->Query_Model->GetMaestroByTelefono($telefono);
            $res['id']        = $this->Query_Model->GetPadreById($padre);
        }
        else if($maestro != "0"){
            $res['telefono'] = $this->Query_Model->GetMaestroByTelefono($telefono);
            $res['id']       = $this->Query_Model->GetMaestroById($maestro);
        }
        echo json_encode($res);
    }
    /* Verificar si el alumno ya existe en la BD para evitar que se repitan */
    function CheckNinoExistente(){
        $nino   = $this->input->post("id_nino");
        $id     = $this->input->post("id_padre");
        $res    = array();

        $res['nino']  = $this->Query_Model->GetNinoById($nino);
        $res['padre'] = $this->Query_Model->GetPadreByIdNino($id);
        echo json_encode($res);
    }
    /* Verificar si el email ya existe en la BD para evitar que se repitan */
    function CheckEmailExistente(){
        $email   = $this->input->post("email");
        $padre   = $this->input->post("id_padre");
        $maestro = $this->input->post("id_maestro");
        if ($padre != "0"){
            $res['email'] = $this->Query_Model->GetPadreByEmail($email);
            $res['id']    = $this->Query_Model->GetPadreById($padre);
        }
        else if($maestro != "0"){
            $res['email'] = $this->Query_Model->GetMaestroByEmail($email);
            $res['id']    = $this->Query_Model->GetMaestroById($maestro);
        }        
        echo json_encode($res);
    }
    /* Guardar registro del Padre */
    public function SavePadre(){        
        $nombre    = $this->input->post("nombre");
        $apaterno  = $this->input->post("apaterno");
        $amaterno  = $this->input->post("amaterno");
        $telefono  = $this->input->post("telefono");
        $direccion = $this->input->post("direccion");
        $email     = $this->input->post("email");
        $username  = $this->input->post("username");
        $password  = $this->input->post("password");
        $nino      = $this->input->post("nino");
    
        $datos_padre_tb_padres = array(
            'nombre'    => $nombre,
            'apaterno'  => $apaterno,
            'amaterno'  => $amaterno,
            'telefono'  => $telefono,
            'direccion' => $direccion,
            'id_nino'   => $nino
        );

        $datos_padre_tb_usuarios = array(
            'nombre'    => $nombre,
            'apaterno'  => $apaterno,
            'amaterno'  => $amaterno,
            'email'     => $email,
            'username'  => $username,
            'password'  => $password,
            'role'      => 'Padre',
            'estado'    => '1'
        );
    
        $this->Query_Model->InsertPadreInTbPadres($datos_padre_tb_padres);
        $this->Query_Model->InsertPadreInTbUsuarios($datos_padre_tb_usuarios);
        $this->Query_Model->InsertIdPadreIntoTbUsuarios();
    }
    /* Actualizar el registro del Padre */
    public function UpdatePadre(){ 
        $id         = $this->input->post('id');
        $nombre     = $this->input->post("nombre");
        $apaterno   = $this->input->post("apaterno");
        $amaterno   = $this->input->post("amaterno");
        $telefono   = $this->input->post("telefono");
        $direccion  = $this->input->post("direccion");
        $email      = $this->input->post("email");
        $username   = $this->input->post("username");
        $password   = $this->input->post("password");
        $nino       = $this->input->post("nino");
        $estado     = $this->input->post("estado");
    
        $datos_padre_tb_padres = array(
            'nombre'    => $nombre,
            'apaterno'  => $apaterno,
            'amaterno'  => $amaterno,
            'telefono'  => $telefono,
            'direccion' => $direccion,
            'id_nino'   => $nino
        );

        $datos_padre_tb_usuarios = array(
            'nombre'    => $nombre,
            'apaterno'  => $apaterno,
            'amaterno'  => $amaterno,
            'email'     => $email,
            'username'  => $username,
            'password'  => $password,
            'estado'    => $estado
        );

        $datos_padre_tb_ninos = array(
            'id_padre' => $id
        );
    
        $this->Query_Model->UpdatePadreInTbPadres($id,$datos_padre_tb_padres);
        $this->Query_Model->UpdatePadreInTbUsuarios($id,$datos_padre_tb_usuarios);
        if ($nino == "0"){
            $this->Query_Model->UpdatePadre2InTbNinos($id,0);
        }else{
            $this->Query_Model->UpdatePadreInTbNinos($nino,$datos_padre_tb_ninos);
        }    
    }
    /* Borrar el registro del Padre */
    public function DeletePadre(){
        $id     = $this->input->post('id');
        $estado = $this->input->post('estado');

        $datospadre = array(
            'estado' => 0
        );        

        $this->Query_Model->DeletePadreTbUsuarios($id,$datospadre);
        redirect('/Padres');
    }
    /* Borrar el registro del niño de todas las tablas */
    public function DeleteNinoFromPadre(){
        $id = $this->input->post('id');

        $datospadre = array(
            'estado' => 0
        );

        $datosnino = array(
            'estado_nino' => 0
        );

        $this->Query_Model->DeletePadreTbUsuarios($id,$datospadre);
        $this->Query_Model->DeleteNinoTbNinos($id,$datosnino);
        redirect('/Padres');
    }
    /* Obtener el padre mediante el ID asignado */
    public function PadrePorId(){
        $id  = $this->input->post('id');
        $res = $this->Query_Model->GetPadreById($id);
        echo json_encode($res);
    }
}
