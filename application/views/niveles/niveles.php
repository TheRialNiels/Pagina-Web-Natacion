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
                events: myBase_url+"index.php/Niveles/listarTodasClases",
                /* Funcion para cuando le den click a un evento registrado en el calendario */
                eventClick: function(info){
                    document.getElementById('btnEliminar').style.display = 'none';
                    document.getElementById('btnGuardar').style.display = 'none';
                    document.getElementById('titulo').textContent = "Datos Clase";
                    document.getElementById('id').value = info.event.id;
                    document.getElementById('nombre_alumno').value = info.event._def.extendedProps.id_nino + "|" + info.event.title;
                    document.getElementById('hora_clase').value = info.event._def.extendedProps.hora_clase;
                    document.getElementById('fecha_clase').value = info.event.startStr;
                    document.getElementById('maestro').value = info.event._def.extendedProps.id_maestro + "|" + info.event._def.extendedProps.nombre_maestro;
                    document.getElementById('color').value = info.event.backgroundColor;
                    document.getElementById('nivel').value = info.event._def.extendedProps.nivel_clase;
                    $('#nombre_alumno').attr('disabled',true);
                    $('#nivel').attr('disabled',true);
                    $('#fecha_clase').attr('disabled',true);
                    $('#maestro').attr('disabled',true);
                    $('#hora_clase').attr('disabled',true);
                    $("#myModal").modal();
                }
            });
            /* Mostrar el calendario */
            calendar.render();
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
                            <h4 class="page-title">Todos los niveles</h4>
                        </div>
                    </div>
                    <br>
                    <div class="col-lg-12">
                        <div class="panel panel-border panel-info">                                    
                            <div class="panel-heading">
                                <h3 class="panel-title">Listado de Alumnos De Todos Los Niveles</h3>
                            </div>
                            <div class="table-responsive">                                    
                                <div class="panel-body">
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
                                        <input align="center" type="button" value="Generar PDF" id="botonPDF" class="btn btn-info" onclick="NivelesActivos();"/>
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
                                                    <?php
                                                        $valores = count($data);
                                                        for ($i=0; $i < $valores ; $i++) { 
                                                            $res = $data[$i];
                                                            $id = $res -> id_nino;
                                                            $nombrecompleto = $res -> title;

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
                                                        $valores = count($data);
                                                        for ($i=0; $i < $valores ; $i++) { 
                                                            $res = $data[$i];
                                                            $id = $res -> id_maestro;
                                                            $nombrecompleto = $res -> nombre_maestro;
                                                            echo "<option value='$id|$nombrecompleto' >$nombrecompleto</option>";
                                                        }
                                                    ?>                                  
                                                </select>
                                            </div>
                                            <div style="width:25%;">
                                                <label for="nivel" class="form-label">Nivel</label>
                                                <select id="nivel" name="nivel" class="form-control" style="width:65%;">
                                                    <?php
                                                        $valores = count($data);
                                                        for ($i=0; $i < $valores ; $i++) { 
                                                            $res = $data[$i];
                                                            $nivel = $res -> nivel_clase;

                                                            echo "<option value='$nivel' >$nivel</option>";
                                                        }
                                                    ?>                                  
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