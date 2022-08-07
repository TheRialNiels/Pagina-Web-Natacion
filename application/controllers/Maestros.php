<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Maestros extends MY_Controller {        
    public function __construct() {
        parent::__construct();
    }
    public function index(){
        $data['tabTitle']    = "Registro de Maestros";
        $data['pagecontent'] = "maestros/maestros";
        $data['maestros']    = $this->Query_Model->DataMaestros();
        
        $this->loadpageintotemplate($data);       
    }
    /* Guardar Maestro */
    public function SaveMaestro(){        
        $nombre    = $this->input->post("nombre");
        $apaterno  = $this->input->post("apaterno");
        $amaterno  = $this->input->post("amaterno");
        $telefono  = $this->input->post("telefono");
        $direccion = $this->input->post("direccion");
        $email     = $this->input->post("email");
        $username  = $this->input->post("username");
        $password  = $this->input->post("password");
        $nivel     = $this->input->post("nivel");
    
        $datos_maestro_tb_maestros = array(
            'nombre'    => $nombre,
            'apaterno'  => $apaterno,
            'amaterno'  => $amaterno,
            'telefono'  => $telefono,
            'nivel'     => $nivel,
            'direccion' => $direccion
        );

        $datos_maestro_tb_usuarios = array(
            'nombre' => $nombre,
            'apaterno' => $apaterno,
            'amaterno' => $amaterno,
            'email' => $email,
            'username' => $username,
            'password' => $password,
            'role' => 'Maestro',
            'estado' => '1'
        );
    
        $this->Query_Model->InsertMaestroInTbMaestros($datos_maestro_tb_maestros);
        $this->Query_Model->InsertMaestroInTbUsuarios($datos_maestro_tb_usuarios);
        $this->Query_Model->InsertIdMaestroIntoTbUsuarios();        
    }
    /* Actualizar Maestro */
    public function UpdateMaestro(){ 
        $id         = $this->input->post('id');
        $nombre     = $this->input->post("nombre");
        $apaterno   = $this->input->post("apaterno");
        $amaterno   = $this->input->post("amaterno");
        $telefono   = $this->input->post("telefono");
        $direccion  = $this->input->post("direccion");
        $email      = $this->input->post("email");
        $username   = $this->input->post("username");
        $password   = $this->input->post("password");
        $estado     = $this->input->post("estado");
        $nivel      = $this->input->post("nivel");
    
        $datos_maestro_tb_maestros = array(
            'nombre'    => $nombre,
            'apaterno'  => $apaterno,
            'amaterno'  => $amaterno,
            'telefono'  => $telefono,
            'direccion' => $direccion,
            'nivel'     => $nivel
        );

        $datos_maestro_tb_usuarios = array(
            'nombre'    => $nombre,
            'apaterno'  => $apaterno,
            'amaterno'  => $amaterno,
            'email'     => $email,
            'username'  => $username,
            'password'  => $password,
            'estado'    => $estado
        );
    
        $this->Query_Model->UpdateMaestroInTbMaestros($id,$datos_maestro_tb_maestros);
        $this->Query_Model->UpdateMaestroInTbUsuarios($id,$datos_maestro_tb_usuarios);    
    }
    /* Borrar Maestro */
    public function DeleteMaestro(){
        $id = $this->input->post('id');

        $datosmaestro = array(
            'estado' => 0
        );

        $this->Query_Model->DeleteMaestroTbUsuarios($id,$datosmaestro);
        redirect('/Maestros');
    }
    /* Obtener el maestro mediante el ID asignado */
    public function MaestroPorId(){
        $id  = $this->input->post('id');
        $res = $this->Query_Model->GetMaestroById($id);
        echo json_encode($res);
    }
    /* Verificar si el email ya está registrado en la base de datos */
    function CheckEmailExistente(){
        $email   = $this->input->post("email");
        $padre   = $this->input->post("id_padre");
        $maestro = $this->input->post("id_maestro");
        
        if($maestro != "0"){
            $res['email'] = $this->Query_Model->GetMaestroByEmail($email);
            $res['id']    = $this->Query_Model->GetMaestroById($maestro);
        }
        else if ($padre != "0"){
            $res['email'] = $this->Query_Model->GetPadreByEmail($email);
            $res['id']    = $this->Query_Model->GetPadreById($padre);
        }
        
        echo json_encode($res);
    }
    /* Verificar si el telefono ya está registrado en la base de datos */
    function CheckTelefonoExistente(){
        $telefono   = $this->input->post("telefono");
        $padre      = $this->input->post("id_padre");
        $maestro    = $this->input->post("id_maestro");

        if($maestro != "0"){
            $res['telefonoM'] = $this->Query_Model->GetMaestroByTelefono($telefono);
            $res['telefonoP'] = $this->Query_Model->GetPadreByTelefono($telefono);
            $res['id']        = $this->Query_Model->GetMaestroById($maestro);
        }
        else if ($padre != "0"){
            $res['telefonoP'] = $this->Query_Model->GetPadreByTelefono($telefono);
            $res['telefonoM'] = $this->Query_Model->GetMaestroByTelefono($telefono);
            $res['id']        = $this->Query_Model->GetPadreById($padre);
        }

        echo json_encode($res);
    }
}
