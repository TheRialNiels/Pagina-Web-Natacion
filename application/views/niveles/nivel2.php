<!-- Content Wrapper. Contains page content -->
<?php
    /* Dependencias requeridas para el funcionamiento de la DataTable */
        /*  ==============================================================
                            <---  CSS TEMPLATE  --->
            ============================================================== */
            echo link_tag('assets/darktemplate/plugins/bootstrap-sweetalert/sweet-alert.css');
            echo link_tag('assets/darktemplate/plugins/fullcalendar/css/main.css');
        /*  ==============================================================
                            <---  JS TEMPLATE  --->
            ============================================================== */
            echo script_tag("assets/darktemplate/plugins/bootstrap-sweetalert/sweet-alert.js");
            echo script_tag("assets/darktemplate/pages/jquery.sweet-alert.init.js");
            echo script_tag("assets/darktemplate/plugins/datatables/pdfmake.min.js");
            echo script_tag("assets/darktemplate/plugins/datatables/vfs_fonts.js");
            echo script_tag('assets/myapp/js/moment.min.js');

        /*  ==============================================================
                            <---  JS MYAPP  --->
            ============================================================== */
            echo script_tag("assets/myapp/js/MY_Functions.js");
            echo script_tag('assets/darktemplate/plugins/fullcalendar/js/main.js');
?>
<html>
    <head>
        <meta charset="utf-8">
    </head>
    <script>
        $(document).ready(function(){
            let frm         = document.getElementById('formulario');
            let eliminar    = document.getElementById('btnEliminar');
            var calendarEl  = document.getElementById('calendar');
            var calendar    = new FullCalendar.Calendar(calendarEl, {
                locale: 'es',
                headerToolbar: {
                    left: 'prev next',
                    center: 'title',
                    right: ''
                },
                events:   myBase_url+"index.php/Nivel2/listarTodasClasesNivel2",
                editable: true,
                /* Funcion para cuando le den click a una fecha */
                dateClick: function(info){
                    $.ajax({
                        url:    myBase_url+"index.php/Nivel2/GetDataNivel2",
                        type:   'POST',
                        async:  true,
                        success:function(datos){        
                            var obj = JSON.parse(datos);
                            frm.reset();
                            document.getElementById('id').value = "";
                            document.getElementById('btnEliminar').style.display = 'none';
                            document.getElementById('fecha_clase').value = info.dateStr;
                            document.getElementById('titulo').textContent = "Agendar Clase";
                            document.getElementById('btnGuardar').textContent = "Registrar";
                            document.getElementById('color').value = "#ff7800";
                            $("#myModal").modal();
                        }
                    });
                },
                /* Funcion para cuando le den click a un evento registrado en el calendario */
                eventClick: function(info){
                    document.getElementById('btnEliminar').style.display = '';
                    document.getElementById('titulo').textContent = "Datos Clase";
                    document.getElementById('id').value = info.event.id;
                    document.getElementById('nombre_alumno').value = info.event._def.extendedProps.id_nino + "|" + info.event.title;
                    document.getElementById('hora_clase').value = info.event._def.extendedProps.hora_clase;
                    document.getElementById('fecha_clase').value = info.event.startStr;
                    document.getElementById('maestro').value = info.event._def.extendedProps.id_maestro + "|" + info.event._def.extendedProps.nombre_maestro;
                    document.getElementById('color').value = info.event.backgroundColor;
                    document.getElementById('btnGuardar').textContent = "Actualizar";
                    $("#myModal").modal();
                },
                /* Funcion para cuando realicen la accion de drag & drop, que actualiza el registro del calendario */
                eventDrop: function(info){
                    const id            = info.event.id;
                    const hora          = info.event.title;
                    const fecha         = info.event.startStr;
                    const id_maestro    = info.event._def.extendedProps.id_maestro;
                    const nivel         = info.event._def.extendedProps.nivel_clase;
                    const url           = myBase_url+"index.php/Nivel2/drop";
                    const http          = new XMLHttpRequest();
                    const data          = new FormData();

                    data.append('id',id);
                    data.append('fecha',fecha);
                    data.append('hora',hora);
                    data.append('id_maestro',id_maestro);
                    data.append('nivel',nivel);
                    http.open('POST',url,true);
                    http.send(data);
                    http.onreadystatechange = function(){
                        if(this.readyState == 4 && this.status == 200){
                            const respuesta = JSON.parse(this.responseText);
                            calendar.refetchEvents();
                            swal("Aviso", respuesta.msg,respuesta.tipo);
                        }
                    }
                }
            });
            /* Mostrar el calendario */
            calendar.render();
            /* Funcion para registrar la info en la BD */
            frm.addEventListener('submit',function(e) {
                e.preventDefault();
                const alumno        = document.getElementById('nombre_alumno').value;
                const hora_clase    = document.getElementById('hora_clase').value;
                const fecha_clase   = document.getElementById('fecha_clase').value;
                const maestro       = document.getElementById('maestro').value;
                const nivel         = document.getElementById('nivel').value;
                const color         = document.getElementById('color').value;
                if(alumno == "" || hora_clase == "" || fecha_clase == "" || maestro == "" || nivel == "" || color == ""){
                    swal("Oh no!", "Aún hay campos vacíos, favor de llenarlos.","warning");
                }else {
                    const url = myBase_url+"index.php/Nivel2/registrar";
                    const http = new XMLHttpRequest();
                    http.open('POST',url,true);
                    http.send(new FormData(frm));
                    http.onreadystatechange = function(){
                        if(this.readyState == 4 && this.status == 200){
                            const respuesta = JSON.parse(this.responseText);
                            if(respuesta.estado){
                                calendar.refetchEvents();
                            }
                            $("#myModal").modal('hide');
                            swal("Aviso", respuesta.msg,respuesta.tipo);
                        }
                    }
                }
            })
            /* Funcion para eliminar la info en la BD */
            eliminar.addEventListener('click',function(){
                $("#myModal").modal('hide');
                swal({
                    title:              "ADVERTENCIA",
                    text:               "¿Está seguro que desea eliminar el registro?",
                    type:               "warning",
                    showCancelButton:   true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText:  "Aceptar",
                    cancelButtonText:   "Cancelar",
                    closeOnConfirm:     false,
                    closeOnCancel:      true
                },
                function(isConfirm){
                    if(isConfirm){
                        const id    = document.getElementById('id').value;
                        const url   = myBase_url+"index.php/Nivel2/eliminar/"+id;
                        const http  = new XMLHttpRequest();
                        
                        http.open('GET',url,true);
                        http.send();
                        http.onreadystatechange = function(){
                            if(this.readyState == 4 && this.status == 200){
                                const respuesta = JSON.parse(this.responseText);
                                if(respuesta.estado){
                                    calendar.refetchEvents();
                                }
                                swal("Aviso", respuesta.msg,respuesta.tipo);
                            }
                        }
                    }
                });
            })
        });
    </script>
    <body class="fixed-left">
        <div id="wrapper">
            <div class="content">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-12">
                            <br>
                            <br>
                            <br>
                            <h4 class="page-title">Nivel 2 (Personalizado)</h4>
                        </div>
                    </div>
                    <br>
                    <div class="col-lg-12">
                        <div class="panel panel-border panel-info">                                    
                            <div class="panel-heading">
                                <h3 class="panel-title">Listado de Alumnos Del Nivel 2</h3>
                            </div>
                            <div class="table-responsive">                                    
                                <div class="panel-body">
                                    <p class="page-text" >Las natación es capaz de mejorar la coordinación y equilibrio de los niños, pero no es sino hasta que el aparato locomotor se encuentra 
                                        los suficientemente desarrollado cuando pueden comenzar las clases de natación para niños; mientras son bebés lo principal es que aprendan a adaptarse al agua, 
                                        pero cuando empiezan a poder controlar sus movimientos 
                                        pueden aprender las técnicas adecuadas de natación. Por lo regular las edades de los niños abarcan desde los 3 hasta los 6 años
                                    </p>
                                    <br>
                                    <table id="datatable" class="table table-striped table-bordered table-responsive">   
                                        <thead>
                                            <tr>
                                                <th>Nombre Completo del Alumno</th>
                                                <th>Telefono de Emergencia</th>
                                                <th>Nivel</th>
                                                <th>Estatus</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                $valores = count($ninos);
                                                for ($i=0; $i < $valores ; $i++) { 
                                                    $res = $ninos[$i];
                                                    $nombre = $res -> nombre_nino;
                                                    $apaterno= $res -> apaterno_nino;
                                                    $amaterno = $res -> amaterno_nino;;
                                                    $nivel = $res -> nivel;
                                                    $telefono = $res -> tel_emergencia;
                                                    $estatus = $res -> estado_nino;

                                                    $nombre_completo = $nombre . ' ' .$apaterno. ' ' .$amaterno;

                                                    echo "
                                                    <tr>
                                                    <td>$nombre_completo</td>
                                                    <td>$telefono</td>
                                                    <td>$nivel</td>
                                                    ";

                                                    if($estatus == 1){
                                                        echo "<td><span class='label label-success'>Activo</span></td>";
                                                    }else{
                                                        echo "<td><span class='label label-danger'>Inactivo</span></td>";
                                                    }  

                                                    
                                                    echo "</tr>";
                                                }
                                            ?>
                                        </tbody>
                                    </table>
                                    <div class="form-group">
                                        <div id="preloader" hidden="true" align="center">
                                            <img src="<?php echo base_url('assets/myapp/img/preloader2.gif');?>" alt="validando...">
                                        </div>
                                    </div>
                                    <div align="center">
                                        <input align="center" type="button" value="Generar PDF" id="botonPDF" class="btn btn-info" onclick="Nivel2Activos();"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="panel panel-border panel-info">                                    
                            <div class="panel-heading">
                                <div id="calendar"></div>
                            </div>        
                        </div>
                    </div>
                    <!-- START MODAL -->
                        <div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="custom-width-modalLabel" aria-hidden="true" style="display: none;">
                            <div class="modal-dialog" style="width:35%;">
                                <div class="modal-content">
                                    <div class="modal-header bg-info" align="center">
                                        <h3 class="modal-title" id="titulo"></h3>
                                    </div>
                                    <form id="formulario">
                                        <div class="modal-body">
                                            <div style="width:55%;">
                                                <input type="text" id="id" name="id" style="display: none;">
                                                <label for="nombre_alumno" class="form-label">Alumno</label>
                                                <select id="nombre_alumno" name="nombre_alumno" class="form-control" style="width:65%;">
                                                    <option value="">Elige Alumno</option>
                                                    <?php
                                                        $valores = count($ninos);
                                                        for ($i=0; $i < $valores ; $i++) { 
                                                            $res = $ninos[$i];
                                                            $id = $res -> id_nino;
                                                            $nombre = $res -> nombre_nino;
                                                            $apaterno= $res -> apaterno_nino;
                                                            $amaterno = $res -> amaterno_nino;
                                                            $nombrecompleto = $nombre . ' ' .$apaterno. ' ' .$amaterno;

                                                            echo "<option value='$id|$nombrecompleto' >$nombrecompleto</option>";
                                                        }
                                                    ?>                                  
                                                </select>
                                            </div>
                                            <div style="width:25%;">
                                                <label for="hora_clase" class="form-label">Hora de Clase</label>
                                                <select id="hora_clase" name="hora_clase" class="form-control">
                                                    <option value="">Elige Horario</option>                                  
                                                    <option value="8a-9a"> 8:00 a.m - 9:00 a.m. </option>
                                                    <option value="9a-10a"> 9:00 a.m - 10:00 a.m. </option>
                                                    <option value="10a-11a"> 10:00 a.m. - 11:00 a.m. </option>
                                                    <option value="11a-12p"> 11:00 a.m. - 12:00 p.m. </option>
                                                    <option value="12p-1p"> 12:00 p.m. - 1:00 p.m. </option>
                                                    <option value="1p-2p"> 1:00 p.m. - 2:00 p.m. </option>
                                                    <option value="2p-3p"> 2:00 p.m. - 3:00 p.m. </option>
                                                    <option value="3p-4p"> 3:00 p.m. - 4:00 p.m. </option>
                                                    <option value="4p-5p"> 4:00 p.m. - 5:00 p.m. </option>
                                                    <option value="5p-6p"> 5:00 p.m. - 6:00 p.m. </option>
                                                    <option value="6p-7p"> 6:00 p.m. - 7:00 p.m. </option>
                                                    <option value="7p-8p"> 7:00 p.m. - 8:00 p.m. </option>
                                                </select>
                                            </div>
                                            <div style="width:25%;">
                                                <label for="fecha_clase" class="form-label">Fecha de Clase</label>
                                                <input type="date" class="form-control" id="fecha_clase" name="fecha_clase">
                                            </div>
                                            <div style="width:55%;">
                                                <label for="maestro" class="form-label">Maestro</label>
                                                <select id="maestro" name="maestro" class="form-control" style="width:55%;">
                                                    <option value="" >Elije Maestro</option>
                                                    <?php
                                                        $valores = count($maestro);
                                                        for ($i=0; $i < $valores ; $i++) { 
                                                            $res = $maestro[$i];
                                                            $id = $res -> id_maestro;
                                                            $nombre = $res -> nombre;
                                                            $apaterno= $res -> apaterno;
                                                            $amaterno = $res -> amaterno;
                                                            $nombrecompleto = $nombre . ' ' .$apaterno. ' ' .$amaterno;
                                                            echo "<option value='$id|$nombrecompleto' >$nombrecompleto</option>";
                                                        }
                                                    ?>                                  
                                                </select>
                                            </div>
                                            <div style="width:25%;">
                                                <label for="nivel" class="form-label">Nivel</label>
                                                <select id="nivel" name="nivel" class="form-control" style="width:65%;">
                                                    <option value='2' >2</option>
                                                </select>
                                            </div>
                                            <div style="width:25%; display: none;">
                                                <label for="color" class="form-label">Color</label>
                                                <input type="color" class="form-control" id="color" name="color">
                                            </div>
                                        </div>
                                        <div class="modal-footer">                                    
                                            <button id="btnCancelar" type="button" class="btn btn-warning btn-custom waves-effect waves-light" data-dismiss="modal">Cancelar</button>
                                            <button id="btnEliminar" type="button" class="btn btn-danger btn-custom waves-effect waves-light">Eliminar</button>
                                            <button id="btnGuardar" type="submit" class="btn btn-info btn-custom waves-effect waves-light"></button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    <!-- END MODAL -->
                </div>
            </div>
        </div>
    </body>
</html>