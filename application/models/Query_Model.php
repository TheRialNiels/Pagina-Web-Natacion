<?php

class Query_Model extends CI_Model{
    /* ========================== */
    /* START - CONTROLLER: Padres */
        /* Insertar datos en las tablas */
        function InsertPadreInTbPadres($datos_padre_padres){
            $this->db->insert('padres',$datos_padre_padres);
        }
        function InsertPadreInTbUsuarios($datos_padre_usuarios){
            $this->db->insert('usuarios',$datos_padre_usuarios);
        }
        /* Insertar el ID del Padre en la tabla de usuarios */
        function InsertIdPadreIntoTbUsuarios(){
            $query = $this->db->query("UPDATE usuarios
                JOIN padres
                ON usuarios.nombre = padres.nombre
                AND usuarios.apaterno = padres.apaterno
                AND usuarios.amaterno = padres.amaterno
                SET usuarios.id_padre = padres.id_padre"
            );
        }
        /* Actualizar datos en las tablas */
        function UpdatePadreInTbPadres($id,$datos_padre_padres){
            $this->db->where('id_padre',$id);
            $this->db->update('padres',$datos_padre_padres);
        }
        function UpdatePadreInTbUsuarios($id,$datos_padre_usuarios){
            $this->db->where('id_padre',$id);
            $this->db->update('usuarios',$datos_padre_usuarios);
        }
        function UpdatePadreInTbNinos($nino,$datos_padre_ninos){
            $this->db->where('id_nino',$nino);
            $this->db->update('ninos',$datos_padre_ninos);
        }
        function UpdatePadre2InTbNinos($id,$datos_padre_ninos){
            $query = $this->db->query("UPDATE ninos SET id_padre = '$datos_padre_ninos' WHERE id_padre = '$id'");
        }
        /* Borrar datos en las tablas */
        function DeletePadreTbUsuarios($id,$datospadre){
            $this->db->where('id_padre', $id);
            $this->db->update('usuarios',$datospadre);
        }
        function DeleteNinoTbNinos($id,$datosnino){
            $this->db->where('id_padre', $id);
            $this->db->update('ninos',$datosnino);
        }
        /* Obtener los datos de las tablas */
        function DataPadres(){
            $query = $this->db->query("SELECT * FROM padres JOIN usuarios as u ON padres.id_padre = u.id_padre WHERE u.role = 'Padre'");
            return $query->result();
        }
        function DataPadresActivos(){
            $query = $this->db->query("SELECT * FROM padres JOIN usuarios as u ON padres.id_padre = u.id_padre WHERE u.role = 'Padre' AND u.estado = '1'");
            return $query->result();
        }
        function DataNinos(){
            $query = $this->db->query("SELECT * FROM ninos");
            return $query->result();
        }
        function DataNinosActivos(){
            $query = $this->db->query("SELECT * FROM ninos WHERE estado_nino = '1'");
            return $query->result();
        }
        /* Obtener los datos del Padre */
        function GetPadreById($id){
            $query = $this->db->query("SELECT p.id_padre, p.nombre, p.apaterno, p.amaterno, p.telefono, p.direccion, 
                u.email, u.username, u.password, u.role, u.estado, 
                n.nombre_nino, n.apaterno_nino, n.amaterno_nino, n.tel_emergencia, n.nivel, n.role_nino, n.id_nino 
                FROM padres AS p 
                INNER JOIN ninos AS n ON p.id_nino = n.id_nino
                INNER JOIN usuarios AS u ON u.id_padre = p.id_padre
                WHERE p.id_padre = '$id'"
            );
            return $query->result();
        }
        /* Obtener los datos del Usuario */
        function GetUserById($id){
            $query = $this->db->query("SELECT * FROM usuarios WHERE id_usuario = '$id'"
            );
            return $query->result();
        }
        /* Obtener los datos del Padre de un alumno en especifico */
        function GetPadreByIdNino($id){
            $query = $this->db->query("SELECT p.id_padre, p.nombre, p.apaterno, p.amaterno,
                n.nombre_nino, n.apaterno_nino, n.amaterno_nino, n.id_nino 
                FROM padres AS p 
                INNER JOIN ninos AS n ON p.id_nino = n.id_nino
                WHERE p.id_padre = '$id'"
            );
            return $query->result();
        }    
        /* Obtener los datos mediante el username del padre */
        function GetPadreByUsername($usuario){
            $this->db->select('*');
            $this->db->from('usuarios');
            $this->db->where('username', $usuario);
            $query = $this->db->get();
            return $query->result();
        }
        /* Obtener los datos mediante el email del padre */
        function GetPadreByEmail($email){
            $query = $this->db->query("SELECT u.id_usuario, u.id_padre, u.id_maestro, u.nombre, u.apaterno, u.amaterno, u.email, u.username, u.role, u.estado,
                p.id_nino, p.telefono, p.direccion
            FROM usuarios as u
            INNER JOIN padres as p ON u.id_padre = p.id_padre
            WHERE u.email = '$email'");
            return $query->result();
        }
        /* Obtener los datos mediante el user del padre */
        function GetPadreByUser($user){
            $query = $this->db->query("SELECT p.id_padre, p.nombre, p.apaterno, p.amaterno,
                u.id_usuario, u.username, u.email,
                n.nombre_nino, n.apaterno_nino, n.amaterno_nino, n.tel_emergencia, n.nivel, n.id_nino 
                FROM padres AS p 
                INNER JOIN ninos AS n ON p.id_padre = n.id_padre
                INNER JOIN usuarios AS u ON p.id_padre = u.id_padre
                WHERE u.username = '$user'"
            );
            return $query->result();
        }
        /* Obtener los datos mediante el telefono del padre */
        function GetPadreByTelefono($telefono){
            $query = $this->db->query("SELECT p.id_padre, p.nombre, p.apaterno, p.amaterno, p.telefono
            FROM padres AS p WHERE p.telefono = '$telefono'");
            return $query->result();
        }
        /* Obtener los datos mediante el telefono del maestro */
        function GetMaestroByTelefono($telefono){
            $query = $this->db->query("SELECT m.id_maestro, m.nombre, m.apaterno, m.amaterno, m.telefono
            FROM maestros AS m WHERE m.telefono = '$telefono'");
            return $query->result();
        }
        /* Obtener los datos mediante el id del alumno */
        function GetNinoById($id){
            $query = $this->db->query("SELECT n.id_nino, n.nombre_nino, n.apaterno_nino, n.amaterno_nino, n.id_padre
                FROM ninos AS n
                WHERE n.id_nino = '$id'"
            );        
            return $query->result();
        }
    /* END - CONTROLLER: Padres */
    /* ======================== */

    /* =========================== */
    /* START - CONTROLLER: Alumnos */
        /* Insertar datos en las tablas */    
        function InsertAlumnoInTbNinos($datos_alumno_ninos){
            $this->db->insert('ninos',$datos_alumno_ninos);
        }
        /* Actualizar datos en las tablas */
        function UpdateAlumnoInTbNinos($id,$datos_alumno_ninos){
            $this->db->where('id_nino',$id);
            $this->db->update('ninos',$datos_alumno_ninos);
        }
        function UpdateAlumnoInTbPadres($id,$datos_alumno_padres){
            $this->db->where('id_padre',$id);
            $this->db->update('padres',$datos_alumno_padres);
        }
        function UpdateAlumno2InTbPadres($id,$datos_alumno_padres){
            $query = $this->db->query("UPDATE padres SET id_nino = '$datos_alumno_padres' WHERE id_nino = '$id'");
        }
        /* Borrar datos en las tablas */
        function DeleteAlumnoTbNinos($id,$datosalumno){
            $this->db->where('id_nino', $id);
            $this->db->update('ninos',$datosalumno);
        }
        function DeleteAlumnoFromTbPadres($id,$datosalumno){
            $this->db->where('id_nino', $id);
            $this->db->update('padres',$datosalumno);
        }
        /* Obtener el ID del alumno */
        function GetAlumnoById($id){
            $query = $this->db->query("SELECT p.id_padre, p.nombre, p.apaterno, p.amaterno,
                n.nombre_nino, n.apaterno_nino, n.amaterno_nino, n.tel_emergencia, n.nivel, n.role_nino, n.estado_nino, n.id_nino 
                FROM padres AS p 
                INNER JOIN ninos AS n ON p.id_padre = n.id_padre
                WHERE n.id_nino = '$id'"
            );
            return $query->result();
        }
    /* END - CONTROLLER: Alumnos */
    /* ========================= */

    /* ============================ */
    /* START - CONTROLLER: Maestros */
        /* Insertar datos en las tablas */
        function InsertMaestroInTbMaestros($datos_maestro_maestros){
            $this->db->insert('maestros',$datos_maestro_maestros);
        }
        function InsertMaestroInTbUsuarios($datos_maestro_usuarios){
            $this->db->insert('usuarios',$datos_maestro_usuarios);
        }
        /* Actualizar datos en las tablas */
        function UpdateMaestroInTbMaestros($id,$datos_maestro_maestros){
            $this->db->where('id_maestro',$id);
            $this->db->update('maestros',$datos_maestro_maestros);
        }
        function UpdateMaestroInTbUsuarios($id,$datos_maestro_usuarios){
            $this->db->where('id_maestro',$id);
            $this->db->update('usuarios',$datos_maestro_usuarios);
        }
        /* Borrar datos en las tablas */
        function DeleteMaestroTbUsuarios($id,$datosmaestro){        
            $this->db->where('id_maestro', $id);
            $this->db->update('usuarios',$datosmaestro);
        }
        /* Obtener datos de la tabla */
        function DataMaestros(){
            $query = $this->db->query("SELECT * FROM maestros JOIN usuarios as u ON maestros.id_maestro = u.id_maestro WHERE u.role = 'Maestro'");
            return $query->result();
        }
        /* Obtener el ID del maestro */
        function GetMaestroById($id){
            $query = $this->db->query("SELECT m.id_maestro, m.nombre, m.apaterno, m.amaterno, m.telefono, m.direccion, m.nivel,
                u.email, u.username, u.password, u.role, u.estado
                FROM maestros AS m
                INNER JOIN usuarios AS u ON u.id_maestro = m.id_maestro
                WHERE m.id_maestro = '$id'"
            );
            return $query->result();
        }
        /* Insertar el ID del Maestro en la tabla de usuarios */
        function InsertIdMaestroIntoTbUsuarios($id,$datos_maestro_usuarios){
            $query = $this->db->query("UPDATE usuarios
                JOIN maestros
                ON usuarios.nombre = maestros.nombre
                AND usuarios.apaterno = maestros.apaterno
                AND usuarios.amaterno = maestros.amaterno
                SET usuarios.id_maestro = maestros.id_maestro"
            );
        }
        /* Obtener los datos por username del maestro */
        function GetMaestroByUsername($usuario){
            $this->db->select('*');
            $this->db->from('usuarios');
            $this->db->where('username', $usuario);

            $query = $this->db->get();
            return $query->result();
        }
        /* Obtener los datos por user del maestro */
        function GetMaestroByUser($user){
            $query = $this->db->query("SELECT m.id_maestro, m.nombre, m.apaterno, m.amaterno, m.nivel,
                u.id_usuario, u.username, u.email
                FROM maestros AS m 
                INNER JOIN usuarios AS u ON m.id_maestro = u.id_maestro
                WHERE u.username = '$user'"
            );
            return $query->result();
        }
        /* Obtener los datos por email del maestro */
        function GetMaestroByEmail($email){
            $query = $this->db->query("SELECT u.id_usuario, u.id_padre, u.id_maestro, u.nombre, u.apaterno, u.amaterno, u.email, u.username, u.role, u.estado,
                    m.nivel, m.telefono, m.direccion
                FROM usuarios as u
                INNER JOIN maestros as m ON u.id_maestro = m.id_maestro
                WHERE u.email = '$email'"
            );
            return $query->result();
        }
    /* END - CONTROLLER: Maestros */
    /* ========================== */

    /* =========================== */
    /* START - CONTROLLER: Niveles */
        function DataNiveles(){
            $query = $this->db->query("SELECT * FROM ninos WHERE nivel != 0");            
            return $query->result();
        }
    /* END - CONTROLLER: Niveles */
    /* ========================= */

    /* =========================== */
    /* START - CONTROLLER: Nivel 1 */
        function DataNivel1(){
            $query = $this->db->query("SELECT * FROM ninos WHERE nivel = '1'");            
            return $query->result();
        }
        function DataMaestrosNivel1(){
            $query = $this->db->query("SELECT * FROM maestros JOIN usuarios as u ON maestros.id_maestro = u.id_maestro WHERE u.role = 'Maestro' AND maestros.nivel = 1");
            return $query->result();
        }
    /* END - CONTROLLER: Nivel 1 */
    /* ========================= */

    /* =========================== */
    /* START - CONTROLLER: Nivel 2 */
        function DataNivel2(){
            $query = $this->db->query("SELECT * FROM ninos WHERE nivel = '2'");            
            return $query->result();
        }
        function DataMaestrosNivel2(){
            $query = $this->db->query("SELECT * FROM maestros JOIN usuarios as u ON maestros.id_maestro = u.id_maestro WHERE u.role = 'Maestro' AND maestros.nivel = 2");
            return $query->result();
        }
    /* END - CONTROLLER: Nivel 2 */
    /* ========================= */

    /* =========================== */
    /* START - CONTROLLER: Nivel 3 */
        function DataNivel3(){
            $query = $this->db->query("SELECT * FROM ninos WHERE nivel = '3'");            
            return $query->result();
        }
        function DataMaestrosNivel3(){
            $query = $this->db->query("SELECT * FROM maestros JOIN usuarios as u ON maestros.id_maestro = u.id_maestro WHERE u.role = 'Maestro' AND maestros.nivel = 3");
            return $query->result();
        }
    /* END - CONTROLLER: Nivel 3 */
    /* ========================= */

    /* ============================ */
    /* START - CONTROLLER: Reportes */
        /* Obtener datos de los padres mediante el estado */
        function PadresByEstatus(){
            $query = $this->db->query("SELECT p.id_padre, p.nombre, p.apaterno, p.amaterno, p.telefono, p.direccion, u.email
                FROM padres AS p JOIN usuarios as u ON p.id_padre = u.id_padre WHERE u.estado = '1' AND u.role = 'Padre' AND p.nombre != 'Ninguno'"
            );

            return $query->result();
        }
        /* Obtener datos de los alumnos mediante el estado */
        function AlumnosByEstatus(){
            $query = $this->db->query("SELECT n.id_nino, n.nombre_nino, n.apaterno_nino, n.amaterno_nino, n.tel_emergencia, n.nivel, p.nombre, p.apaterno, p.amaterno
                FROM ninos AS n JOIN padres as p ON p.id_padre = n.id_padre WHERE n.estado_nino = '1' AND n.role_nino = 'Nino' AND n.nombre_nino != 'Ninguno'"
            );

            return $query->result();
        }
        /* Obtener datos de los maestros mediante el estado */
        function MaestrosByEstatus(){
            $query = $this->db->query("SELECT m.id_maestro, m.nombre, m.apaterno, m.amaterno, m.telefono, m.direccion, m.nivel, u.email
                FROM maestros AS m JOIN usuarios as u ON m.id_maestro = u.id_maestro WHERE u.estado = '1' AND u.role = 'Maestro'"
            );
            return $query->result();
        }
        /* Obtener datos de los alumnos de todos niveles mediante el estado */
        function NivelesByEstatus(){
            $query = $this->db->query("SELECT * FROM ninos WHERE nivel != 0 AND estado_nino = '1'");
            return $query->result();
        }
        /* Obtener datos de los alumnos del nivel 1 mediante el estado */
        function Nivel1ByEstatus(){
            $query = $this->db->query("SELECT * FROM ninos WHERE nivel = '1' AND estado_nino = '1'");
            return $query->result();
        }
        /* Obtener datos de los alumnos del nivel 2 mediante el estado */
        function Nivel2ByEstatus(){
            $query = $this->db->query("SELECT * FROM ninos WHERE nivel = '2' AND estado_nino = '1'");
            return $query->result();
        }
        /* Obtener datos de los alumnos del nivel 3 mediante el estado */
        function Nivel3ByEstatus(){
            $query = $this->db->query("SELECT * FROM ninos WHERE nivel = '3' AND estado_nino = '1'");
            return $query->result();
        }
    /* END - CONTROLLER: Reportes */
    /* ========================== */

    /* START - CONTROLLER: Calendario */
    /* ============================== */
        /* Obtener la data del alumno mediante el usuario */
        function GetDataFromNinoByUser($user){
            $query = $this->db->query("SELECT  u.id_usuario, u.username, u.email,
                n.nombre_nino, n.apaterno_nino, n.amaterno_nino, n.nivel, n.id_nino, 
                m.id_maestro, m.nivel, m.nombre, m.apaterno, m.amaterno
                FROM padres AS p 
                INNER JOIN ninos AS n ON p.id_padre = n.id_padre
                INNER JOIN usuarios AS u ON p.id_padre = u.id_padre
                INNER JOIN maestros as m ON n.nivel = m.nivel
                WHERE u.username = '$user'"
            );
            return $query->result();
        }
        /* Obtener la data del maestro mediante el usuario */
        function GetDataFromMaestroByUser($user){
            $query = $this->db->query("SELECT  u.id_usuario, u.username, u.email,
                n.id_nino, n.nombre_nino, n.apaterno_nino, n.amaterno_nino,
                m.id_maestro, m.nombre, m.apaterno, m.amaterno, m.nivel
                FROM maestros AS m
                INNER JOIN ninos AS n ON m.nivel = n.nivel
                INNER JOIN usuarios AS u ON m.id_maestro = u.id_maestro
                WHERE u.username = '$user'"
            );
            return $query->result();
        }
        /* Verificar si la clase ya se encuentra registrada */
        function checkClase($hora_clase,$fecha_clase,$id_maestro,$nivel){
            $query = $this->db->query("SELECT hora_clase, fecha_clase, id_maestro, nivel_clase FROM horarios 
                WHERE hora_clase = '$hora_clase' AND fecha_clase = '$fecha_clase' AND id_maestro = '$id_maestro' AND nivel_clase = '$nivel'"
            );
            return $query->result();
        }
        function registrarClase($datos_agenda_clase){
            $data = $this->db->insert('horarios',$datos_agenda_clase);
            if($data == 1){
                $msg = 1;
            }else{
                $msg = 0;
            }
            return $msg;
        }
        function actualizarClase($id,$datos_agenda_clase){
            $this->db->where('id_horario',$id);
            $data = $this->db->update('horarios',$datos_agenda_clase);
            if($data == 1){
                $msg = 1;
            }else{
                $msg = 0;
            }
            return $msg;
        }
        function eliminarClase($id){
            $this->db->where('id_horario',$id);
            $data = $this->db->delete('horarios');
            if($data == 1){
                $msg = 1;
            }else{
                $msg = 0;
            }
            return $msg;
        }
        /* Realizar un update a la BD al momento de realizar la opcion de drop en el calendario */
        function dropClase($id,$datos_actualiza_clase){
            $this->db->where('id_horario',$id);
            $data = $this->db->update('horarios',$datos_actualiza_clase);
            if($data == 1){
                $msg = 1;
            }else{
                $msg = 0;
            }
            return $msg;
        }
        /* Listar las clases */
        function listarClasesAgendadasBynino($user){
            $query = $this->db->query("SELECT h.id_horario AS id, h.id_nino, h.nombre_alumno, h.hora_clase as title, h.fecha_clase as start, h.id_maestro, h.nombre_maestro, h.nivel_clase, h.color,
                n.id_padre,
                u.username
                FROM horarios AS h
                INNER JOIN ninos AS n ON n.id_nino = h.id_nino
                INNER JOIN usuarios AS u ON u.id_padre = n.id_padre
                WHERE u.username = '$user'"
            );
            return $query->result();
        }
        function listarClasesAgendadasByMaestro($user){
            $query = $this->db->query("SELECT h.id_horario AS id, h.id_nino, h.nombre_alumno as title, h.hora_clase, h.fecha_clase as start, h.id_maestro, h.nombre_maestro, h.nivel_clase, h.color,
                u.username
                FROM horarios AS h
                INNER JOIN usuarios AS u ON u.id_maestro = h.id_maestro
                WHERE u.username = '$user' AND u.role = 'Maestro'"
            );
            return $query->result();
        }
        function listarClasesAgendadas(){
            $query = $this->db->query("SELECT id_horario as id, id_nino, nombre_alumno as title, hora_clase, fecha_clase as start,
                id_maestro, nombre_maestro, nivel_clase, color FROM horarios
                WHERE nivel_clase != 0"
            );
            return $query->result();
        }
        function listarClasesAgendadasNivel1(){
            $query = $this->db->query("SELECT id_horario as id, id_nino, nombre_alumno as title, hora_clase, fecha_clase as start,
                id_maestro, nombre_maestro, nivel_clase, color FROM horarios
                WHERE nivel_clase = 1"
            );
            return $query->result();
        }
        function listarClasesAgendadasNivel2(){
            $query = $this->db->query("SELECT id_horario as id, id_nino, nombre_alumno as title, hora_clase, fecha_clase as start,
                id_maestro, nombre_maestro, nivel_clase, color FROM horarios
                WHERE nivel_clase = 2"
                );
            return $query->result();
        }
        function listarClasesAgendadasNivel3(){
            $query = $this->db->query("SELECT id_horario as id, id_nino, nombre_alumno as title, hora_clase, fecha_clase as start,
                id_maestro, nombre_maestro, nivel_clase, color FROM horarios
                WHERE nivel_clase = 3"
            );
            return $query->result();
        }
    /* END - CONTROLLER: Calendario */
    /* ============================ */
}