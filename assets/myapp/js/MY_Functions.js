/* =========================== */
/* START - CONTROLLER: Session */
    function verifyenterkeypressed(evt){
        var charCode = (evt.which) ? evt.which : event.keyCode;
        if (charCode == 13){
            validateuserlogin();
        }
    }
    function validateuserlogin(){
        var url  = myBase_url+"index.php/Session/validatelogin";
        var user = $('#user').val();
        var pass = $('#password').val();
        $('#fountainTextG').show();
        $.post(url,{user:user,pass:pass},
            function(data){
                sendresponsetouser(data);
            }
        );
    }
    function ResetUserLogin(){
        var userreset = $("#userreset").val();
        var passreset = $("#passwordreset").val();

        if (userreset != ""  && passreset != "") {
            $.ajax({
                url:     myBase_url+"index.php/Session/ResetLogin",
                type:    'POST',
                data:    {userreset:userreset,passreset:passreset},
                async:   true,
                success: function(datos){
                    var response = JSON.parse(datos);
                    if (response == "UWOA") {
                        swal("Error","Usuario sin acceso a esta aplicación","error");        
                    }else if(response == "IUOP"){
                        swal("Error","Usuario o contraseña incorecta","error");
                    }else{
                        swal({   
                            title:              "Exito",
                            text:               "Se ha reseteado la sesion con exito",   
                            type:               "success",   
                            showCancelButton:   false,   
                            confirmButtonColor: "#DD6B55",   
                            confirmButtonText:  "OK",   
                            cancelButtonText:   "No, Cancelar",   
                            closeOnConfirm:     true,   
                            closeOnCancel:      false 
                        }, function(isConfirm){                              
                            location.href = "";  
                        });
                    }
                },
                error:function(){
                    swal("Error","Ha ocurrido un error intentelo de nuevo","error");
                }
            });        
        }else{
            swal("Cuidado", "Aun quedan campos vacios", "warning")
        }
    }
    function sendresponsetouser(data){
        var dato = data.trim();  
        if(dato.substring(0,3) === "OK-"){
            openurl(dato);
        }else if(dato.substring(0,4)==="UWOA"){
            swal("Advertencia","Usuario sin acceso a esta aplicación","warning");
            $('#fountainTextG').hide();
            $('#user').val("");
            $('#password').val("");
            setTimeout(closeresponsetouser, 10000);
        }else if(dato.substring(0,4)==="IUOP"){
            swal("Advertencia","Usuario y/o contraseña incorrectos","warning");
            $('#fountainTextG').hide();
            $('#user').val("");
            $('#password').val("");
        } else if(dato.substring(0,4)==="UWAS"){
            swal("Advertencia","Usuario ya cuenta con una sesion activa","warning");
            $('#fountainTextG').hide();
            $('#user').val("");
            $('#password').val("");
        } else{            
            swal("Advertencia",'El campo "Usuario" y "Contraseña" es requerido',"warning");
            $('#fountainTextG').hide();
        }
    }
    function openurl(str){
        $('#fountainTextG').hide();
        var sp  = str.split("-");
        var url = myBase_url+"index.php/"+sp[1];
        window.location.href = url;
    }
    function displaymessage(message){
        $('#fountainTextG').hide();
        var msg = '<div class="alert alert-danger alert-dismissable fade in">\n\
                        <button type="button" class="close close-sm" data-dismiss="alert" >\n\
                        <i class="md md-close"></i>\n\
                        </button>\n\
                        <strong>¡Error!</strong>&nbsp;'+message+'&nbsp;\n\
                </div>';
        $('#displayUserErrors').html(msg);
        setTimeout(closeresponsetouser, 10000);
    }
    function LogOut(){
        $.ajax({
            url:myBase_url+"index.php/Session/logout",
            type:'GET',
            async: true,
            success:function(datos){
                swal({   
                    title: "Error",
                    text: "La sesion ha caducado, porfavor inicia sesion de nuevo",   
                    type: "error",   
                    showCancelButton: false,   
                    confirmButtonColor: "#DD6B55",   
                    confirmButtonText: "OK",   
                    cancelButtonText: "Cancelar",   
                    closeOnConfirm: false,   
                    closeOnCancel: false 
                }, function(isConfirm){ 
                        location.href = myBase_url+"index.php/Session";       
                });     
            }
        });   
    }
    function CheckUActivo(){
        $.ajax({
            url:myBase_url+"index.php/Session/EstadoU",
            type:'GET',
            async: true,
            success:function(datos){
                var obj = JSON.parse(datos);
                if(obj != ""){
                    console.log("OK");
                }else{
                    $.ajax({
                        url:myBase_url+"index.php/Session/logout",
                        type:'GET',
                        async: true,
                        success:function(datos){
                            swal({   
                                title: "Error",
                                text: "Tu cuenta ha sido eliminada, para mayor informacion acude con el administrador",   
                                type: "error",   
                                showCancelButton: false,   
                                confirmButtonColor: "#DD6B55",   
                                confirmButtonText: "OK",   
                                cancelButtonText: "Cancelar",   
                                closeOnConfirm: false,   
                                closeOnCancel: false 
                            }, function(isConfirm){ 
                                location.href = myBase_url+"index.php/Session";       
                            }); 
                        }
                    });
                }  
            }
        });
    }
/* END - CONTROLLER: Session */
/* ========================= */

/* ========================== */
/* START - CONTROLLER: Padres */
    /* Funcion para corroborar si el usuario ya existe en la base de datos */
    function VerificaUser(){
        var usuario = $('#username').val();
        if(usuario != ""){
            $.ajax({
                url:    myBase_url+"index.php/Padres/CheckUsuarioExistente",
                type:   'POST',
                data:   {username:usuario},
                async:  true,
                success:function(datos){
                    var obj = JSON.parse(datos);
                    if(obj != ""){
                        swal("Error", "El usuario ya existe, intentelo de nuevo","error");
                        $('#username').val("");
                    }
                },
                error:function() {
                    swal("Error", "Ha ocurrido un error intentelo de nuevo","error");                
                }
            });
        }else {
            swal("Cuidado","El campo de usuario está vacío","warning");
        }
    }
    /* Funcion para corroborar si el padre ya existe en la base de datos */
    function VerificaPadreTelefono(){
        var telefono = $('#telefono').val();
        var user = $('#id_user').val();
        if(telefono != ""){
            $.ajax({
                url:    myBase_url+"index.php/Padres/CheckTelefonoExistente",
                type:   'POST',
                data:   {telefono:telefono,id_padre:user},
                async:  true,
                success:function(datos){
                    var obj             = JSON.parse(datos);
                    var datosPadre      = obj['telefonoP'];
                    var datosMaestro    = obj['telefonoM'];
                    var telefono_padre  = obj['id'][0].telefono;
                    if(datosPadre != ""){
                        var telefonoP_introducido = obj['telefonoP'][0].telefono;
                        var id_padre_introducido  = obj['telefonoP'][0].id_padre;
                        if (telefono_padre == ""){
                            swal("Error", "El telefono ya existe, intentelo de nuevo","error");
                            $('#telefono').val("");
                        }
                        else {
                            if(telefono == telefono_padre){    
                            }
                            else if(telefono == telefonoP_introducido && user != id_padre_introducido){
                                swal("Error", "El telefono ya existe, intentelo de nuevo","error");
                                if(user != ""){
                                    $('#telefono').val(telefono_padre);
                                } else {
                                    $('#telefono').val("");
                                }
                            }
                        }
                    }
                    else if (datosMaestro != ""){
                        var telefonoM_introducido  = obj['telefonoM'][0].telefono;
                        var id_maestro_introducido = obj['telefonoM'][0].id_padre;
                        if (telefono_padre == ""){
                            swal("Error", "El telefono ya existe, intentelo de nuevo","error");
                            $('#telefono').val("");
                        }
                        else {
                            if(telefono == telefono_padre){    
                            }
                            else if(telefono == telefonoM_introducido && user != id_maestro_introducido){
                                swal("Error", "El telefono ya existe, intentelo de nuevo","error");
                                if(user != ""){
                                    $('#telefono').val(telefono_padre);
                                } else {
                                    $('#telefono').val("");
                                }
                            }
                        }
                    }
                },
                error:function() {
                    swal("Error", "Ha ocurrido un error intentelo de nuevo","error");                
                }
            });
        }
    }
    /* Funcion para corroborar si el alumno ya existe en la base de datos */
    function VerificaHijo(){
        var nino = $('#nino').val();
        var padre = $('#id_user').val();
        if(nino != ""){
            $.ajax({
                url:    myBase_url+"index.php/Padres/CheckNinoExistente",
                type:   'POST',
                data:   {id_nino:nino,id_padre:padre},
                async:  true,
                success:function(datos){
                    var obj = JSON.parse(datos);
                    var id  = obj['nino'][0].id_padre;
                    if(nino == obj['padre'][0].id_nino){
                    }
                    else if(id != "0"){
                        swal("Error", "El alumno ya está asociado a un padre, intentelo de nuevo","error");
                        $('#nino').val(obj['padre'][0].id_nino);
                    }
                },
                error:function() {
                    swal("Error", "Ha ocurrido un error intentelo de nuevo","error");                
                }
            });
        }else {
            swal("Cuidado","El campo de hijo está vacío","warning");
        }
    }
    /* Funcion para corroborar si el email ya existe en la base de datos */
    function VerificaEmailPadre(){
        var email = $('#email').val();
        var user = $('#id_user').val();
        if(email != ""){
            $.ajax({
                url:    myBase_url+"index.php/Padres/CheckEmailExistente",
                type:   'POST',
                data:   {email:email,id_padre:user},
                async:  true,
                success:function(datos){
                    var obj          = JSON.parse(datos);
                    var email_padre  = obj['id'][0].email;
                    if(user == ""){
                        if($('#email').val().indexOf('@', 0) == -1 || $('#email').val().indexOf('.', 0) == -1) {
                            swal("Alerta",'El correo electrónico introducido no es correcto.',"warning");
                            $('#email').val("");
                        }
                    } else if (user != "0"){
                        if($('#email').val().indexOf('@', 0) == -1 || $('#email').val().indexOf('.', 0) == -1) {
                            swal("Alerta",'El correo electrónico introducido no es correcto.',"warning");
                            $('#email').val(email_padre);
                        }
                    }
                    var email_introducido    = obj['email'][0].email;
                    var id_padre_introducido = obj['email'][0].id_padre;

                    if(email == email_padre){
                    }
                    else if(email == email_introducido && user != id_padre_introducido){
                        swal("Error", "El email ya existe, intentelo de nuevo","error");
                        if(user != ""){
                            $('#email').val(email_padre);
                        } else {
                            $('#email').val("");
                        }
                    }
                },
                error:function() {
                    swal("Error", "Ha ocurrido un error intentelo de nuevo","error");                
                }
            });
        }else {
            swal("Cuidado","El campo de email está vacío","warning");
        }
    }
    function GuardarPadre(){
        var nombre      = $('#nombre').val();
        var apaterno    = $('#apaterno').val();
        var amaterno    = $('#amaterno').val();
        var telefono    = $('#telefono').val();
        var direccion   = $('#direccion').val();
        var email       = $('#email').val();
        var username    = $('#username').val();
        var password    = $('#password').val();
        var nino        = $('#nino').val();

        if(nombre != "" && apaterno != "" && amaterno != "" && telefono != "" && direccion != "" && email != "" && username != "" && password != "" && nino != ""){
            $.ajax({
                url:     myBase_url+"index.php/Padres/SavePadre",
                type:    'POST',
                data:    {nombre:nombre,apaterno:apaterno,amaterno:amaterno,telefono:telefono,direccion:direccion,email:email,username:username,password:password,nino:nino},
                async:   true,
                success: function(datos){
                    swal({
                        title:              "Exito",
                        text:               "Se ha guardado el usuario con exito",
                        type:               "success",
                        showCancelButton:   false,
                        confirmButtonColor: "#DD6B55",
                        confirmButtonText:  "OK",
                        cancelButtonText:   "No, Cancelar",
                        closeOnConfirm:     true,
                        closeOnCancel:      false
                    }, function(isConfirm){
                        location.href = "";
                    });
                },
            });
        }else{
            swal("Cuidado","Aun existen campos vacios","warning");
        }
    }
    function EditarPadre($id){
        var id = $id;
        $.ajax({
            url:    myBase_url+"index.php/Padres/PadrePorId",
            type:   'POST',
            data:   {id:id},
            async:  true,
            success:function(datos){
                var obj          = JSON.parse(datos);
                var id           = obj[0].id_padre;
                var nombre       = obj[0].nombre;
                var apaterno     = obj[0].apaterno;
                var amaterno     = obj[0].amaterno;
                var telefono     = obj[0].telefono;
                var direccion    = obj[0].direccion;
                var email        = obj[0].email;
                var usuario      = obj[0].username;
                var password     = obj[0].password;
                var nino         = obj[0].id_nino;
                var estado       = obj[0].estado;
                
                $('#username').attr('disabled',true);
                $('#password').attr('disabled',true);
                
                $('#btn-guardar').hide();
                $('#btn-update').show();
                $('#btn-cancel').show();
                $('#div-estado').show();

                $('#id_user').val(id);
                $('#nombre').val(nombre);
                $('#apaterno').val(apaterno);
                $('#amaterno').val(amaterno);
                $('#telefono').val(telefono);
                $('#direccion').val(direccion);
                $('#email').val(email);
                $('#username').val(usuario);
                $('#password').val(password);
                $('#nino').val(nino);
                $('#estado').val(estado);
            },
            error:function() {
                swal("Error", "Ha ocurrido un error intentelo de nuevo","error");            
            }
        });
    }
    function BorrarPadre($id){
        var id = $id;
        swal({
            title:              "ADVERTENCIA",
            text:               "¿Desea eliminar el registro del niño asociado con el padre?",
            type:               "warning",
            showCancelButton:   true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText:  "Aceptar",
            cancelButtonText:   "No, Solo el padre",
            denyButtonText:     "Cancelar",
            closeOnConfirm:     false,
            closeOnCancel:      true
        },function(isConfirm){
            if(isConfirm){
                var id = $id;
                $.ajax({
                    url:     myBase_url+"index.php/Padres/DeleteNinoFromPadre",
                    type:    'POST',
                    data:    {id:id},
                    async:   true,
                    success: function(datos){
                        swal({
                            title:              "Exito",
                            text:               "Se ha eliminado el registro del niño con exito ",
                            type:               "success",
                            showCancelButton:   false,
                            confirmButtonColor: "#DD6B55",
                            confirmButtonText:  "OK",
                            cancelButtonText:   "No, Cancelar",
                            closeOnConfirm:     true,
                            closeOnCancel:      false
                        }, function(isConfirm){
                                location.href = "";
                        });
                    },error:function (){
                        swal("Error","Ha ocurrido un error intentelo de nuevo","error");
                    }
                });
            } else {
                var id = $id;
                $.ajax({
                    url:     myBase_url+"index.php/Padres/DeletePadre",
                    type:    'POST',
                    data:    {id:id},
                    async:   true,
                    success: function(datos){
                        swal({
                            title:              "Exito",
                            text:               "Se ha borrado el usuario con exito",
                            type:               "success",
                            showCancelButton:   false,
                            confirmButtonColor: "#DD6B55",
                            confirmButtonText:  "OK",
                            cancelButtonText:   "No, Cancelar",
                            closeOnConfirm:     true,
                            closeOnCancel:      false
                        }, function(isConfirm){
                            location.href = "";
                        });
                    },
                    error:function() {
                        swal("Error", "Ha ocurrido un error intentelo de nuevo","error");                        
                    }
                });
            }
        });
    }
    function ActualizarPadre(){
        var id          = $('#id_user').val();
        var nombre      = $('#nombre').val();
        var apaterno    = $('#apaterno').val();
        var amaterno    = $('#amaterno').val();
        var telefono    = $('#telefono').val();
        var direccion   = $('#direccion').val();
        var email       = $('#email').val();
        var username    = $('#username').val();
        var password    = $('#password').val();
        var nino        = $('#nino').val();
        var estado      = $('#estado').val();

        if(id != "" && nombre != "" && apaterno != "" && amaterno != "" && telefono != "" && direccion != "" && email != "" && username != "" && password != "" && nino != "" && estado != ""){
            $.ajax({
                url:    myBase_url+"index.php/Padres/UpdatePadre",
                type:   'POST',
                data:   {id:id,nombre:nombre,apaterno:apaterno,amaterno:amaterno,telefono:telefono,direccion:direccion,email:email,username:username,password:password,nino:nino,estado:estado},
                async:  true,
                success:function(datos){
                    swal({
                        title:              "Exito",
                        text:               "Se ha actualizado el usuario con exito",
                        type:               "success",
                        showCancelButton:   false,
                        confirmButtonColor: "#DD6B55",
                        confirmButtonText:  "OK",
                        cancelButtonText:   "No, Cancelar",
                        closeOnConfirm:     true,
                        closeOnCancel:      false
                    }, function(isConfirm){
                        location.href = "";
                    });
                },
                error:function() {
                    swal("Error", "Ha ocurrido un error intentelo de nuevo","error");
                },
            });
        }else{
            swal("Cuidado","Aun existen campos vacios","warning");
        }
    }
    /* Vaciar los campos */
    function CancelarActualizacionPadre(){
        $('#username').attr('disabled',false);
        $('#password').attr('disabled',false);
        $('#btn-guardar').show();
        $('#btn-update').hide();
        $('#btn-cancel').hide();
        $('#div-estado').hide();

        $('#id_user').val("");
        $('#nombre').val("");
        $('#apaterno').val("");
        $('#amaterno').val("");
        $('#telefono').val("");
        $('#direccion').val("");
        $('#email').val("");
        $('#username').val("");
        $('#password').val("");
        $('#nino').val("");
    }
/* END - CONTROLLER: Padres */
/* ======================== */

/* =========================== */
/* START - CONTROLLER: Alumnos */
    /* Funcion para corroborar si el padre ya existe en la base de datos */
    function VerificaPadre(){
        var padre   = $('#padre').val();
        var nino    = $('#id_alumno').val();
        if(padre != ""){
            $.ajax({
                url:    myBase_url+"index.php/Alumnos/CheckPadreExistente",
                type:   'POST',
                data:   {id_nino:nino,id_padre:padre},
                async:  true,
                success:function(datos){
                    var obj = JSON.parse(datos);
                    var id  = obj['padre'][0].id_nino;
                    if(padre == obj['nino'][0].id_padre || padre == "0"){
                    }
                    else if(id != "0"){
                        swal("Error", "El padre ya está asociado a un alumno, intentelo de nuevo","error");
                        $('#padre').val(obj['nino'][0].id_padre);
                    }
                },
                error:function() {
                    swal("Error", "Ha ocurrido un error intentelo de nuevo","error");                
                }
            });
        }else {
            swal("Cuidado","El campo de padre está vacío","warning");
        }
    }    
    function GuardarAlumno(){
        var nombre         = $('#nombre').val();
        var apaterno       = $('#apaterno').val();
        var amaterno       = $('#amaterno').val();
        var tel_emergencia = $('#tel_emergencia').val();
        var nivel          = $('#nivel').val();

        if(nombre != "" && apaterno != "" && amaterno != "" && tel_emergencia != "" && nivel != ""){
            $.ajax({
                url:     myBase_url+"index.php/Alumnos/SaveAlumno",
                type:    'POST',
                data:    {nombre:nombre,apaterno:apaterno,amaterno:amaterno,tel_emergencia:tel_emergencia,nivel:nivel},
                async:   true,
                success: function(datos){
                    swal({
                        title:              "Exito",
                        text:               "Se ha guardado el alumno con exito",
                        type:               "success",
                        showCancelButton:   false,
                        confirmButtonColor: "#DD6B55",
                        confirmButtonText:  "OK",
                        cancelButtonText:   "No, Cancelar",
                        closeOnConfirm:     true,
                        closeOnCancel:      false
                    }, function(isConfirm){
                        location.href = "";
                    });
                },
            });
        }else{
            swal("Cuidado","Aun existen campos vacios","warning");
        }
    }
    function EditarAlumno($id){
        var id = $id;
        $.ajax({
            url:     myBase_url+"index.php/Alumnos/AlumnoPorId",
            type:    'POST',
            data:    {id:id},
            async:   true,
            success: function(datos){
                var obj            = JSON.parse(datos);
                var id             = obj[0].id_nino;
                var nombre         = obj[0].nombre_nino;
                var apaterno       = obj[0].apaterno_nino;
                var amaterno       = obj[0].amaterno_nino;
                var tel_emergencia = obj[0].tel_emergencia;
                var nivel          = obj[0].nivel;
                var estado         = obj[0].estado_nino;
                var padre          = obj[0].id_padre;
                
                $('#btn-guardar').hide();
                $('#btn-update').show();
                $('#btn-cancel').show();
                $('#div-estado').show();
                $('#div-padre').show();

                $('#id_alumno').val(id);
                $('#nombre').val(nombre);
                $('#apaterno').val(apaterno);
                $('#amaterno').val(amaterno);
                $('#tel_emergencia').val(tel_emergencia);
                $('#nivel').val(nivel);
                $('#estado').val(estado);
                $('#padre').val(padre);
            },
            error:function() {
                swal("Error", "Ha ocurrido un error intentelo de nuevo","error");            
            }
        });
    }
    function BorrarAlumno($id){
        var id = $id;
        swal({
            title:              "ADVERTENCIA",
            text:               "¿Estás seguro?",
            type:               "warning",
            showCancelButton:   true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText:  "Aceptar",
            cancelButtonText:   "Cancelar",
            closeOnConfirm:     false,
            closeOnCancel:      true
        },function(isConfirm){
            if(isConfirm){
                var id = $id;
                $.ajax({
                    url:     myBase_url+"index.php/Alumnos/DeleteAlumno",
                    type:    'POST',
                    data:    {id:id},
                    async:   true,
                    success: function(datos){
                        swal({
                            title:              "Exito",
                            text:               "Se ha borrado el alumno con exito",
                            type:               "success",
                            showCancelButton:   false,
                            confirmButtonColor: "#DD6B55",
                            confirmButtonText:  "OK",
                            cancelButtonText:   "No, Cancelar",
                            closeOnConfirm:     true,
                            closeOnCancel:      false
                        }, function(isConfirm){
                            location.href = "";
                        });
                    },
                    error:function() {
                        swal("Error", "Ha ocurrido un error intentelo de nuevo","error");
                        
                    }
                });
            }
        });
    }
    function ActualizarAlumno(){
        var id             = $('#id_alumno').val();
        var nombre         = $('#nombre').val();
        var apaterno       = $('#apaterno').val();
        var amaterno       = $('#amaterno').val();
        var tel_emergencia = $('#tel_emergencia').val();
        var nivel          = $('#nivel').val();
        var estado         = $('#estado').val();
        var padre          = $('#padre').val();

        if(id != "" && nombre != "" && apaterno != "" && amaterno != "" && tel_emergencia != "" && nivel != "" && padre != "" && estado != ""){
            $.ajax({
                url:     myBase_url+"index.php/Alumnos/UpdateAlumno",
                type:    'POST',
                data:    {id:id,nombre:nombre,apaterno:apaterno,amaterno:amaterno,tel_emergencia:tel_emergencia,nivel:nivel,padre:padre,estado:estado},
                async:   true,
                success: function(datos){
                    swal({
                        title:              "Exito",
                        text:               "Se ha actualizado el alumno con exito",
                        type:               "success",
                        showCancelButton:   false,
                        confirmButtonColor: "#DD6B55",
                        confirmButtonText:  "OK",
                        cancelButtonText:   "No, Cancelar",
                        closeOnConfirm:     true,
                        closeOnCancel:      false
                    }, function(isConfirm){
                        location.href = "";
                    });
                },
                error:function() {
                    swal("Error", "Ha ocurrido un error intentelo de nuevo","error");
                },
            });
        }else{
            swal("Cuidado","Aun existen campos vacios","warning");
        }
    }
    /* Vaciar los campos */
    function CancelarActualizacionAlumno(){
        $('#btn-guardar').show();
        $('#btn-update').hide();
        $('#btn-cancel').hide();
        $('#div-estado').hide();
        $('#div-padre').hide();

        $('#id_alumno').val("");
        $('#nombre').val("");
        $('#apaterno').val("");
        $('#amaterno').val("");
        $('#tel_emergencia').val("");
        $('#nivel').val("");
        $('#estado').val("");
        $('#padre').val("");
    }
/* END - CONTROLLER: Alumnos */
/* ========================= */

/* ============================ */
/* START - CONTROLLER: Maestros */
    /* Funcion para corroborar si el email ya existe en la base de datos */
    function VerificaEmailMaestro(){
        var email = $('#email').val();
        var user  = $('#id_user').val();
        if(email != ""){
            $.ajax({
                url:    myBase_url+"index.php/Maestros/CheckEmailExistente",
                type:   'POST',
                data:   {email:email,id_maestro:user},
                async:  true,
                success:function(datos){
                    var obj             = JSON.parse(datos);
                    var email_maestro   = obj['id'][0].email;
                    if(user == ""){
                        if($('#email').val().indexOf('@', 0) == -1 || $('#email').val().indexOf('.', 0) == -1) {
                            swal("Alerta",'El correo electrónico introducido no es correcto.',"warning");
                            $('#email').val("");
                        }
                    } else if (user != "0"){
                        if($('#email').val().indexOf('@', 0) == -1 || $('#email').val().indexOf('.', 0) == -1) {
                            swal("Alerta",'El correo electrónico introducido no es correcto.',"warning");
                            $('#email').val(email_maestro);
                        }
                    }
                    var email_introducido       = obj['email'][0].email;
                    var id_maestro_introducido  = obj['email'][0].id_maestro;
                    if(email == email_maestro){
                    }
                    else if(email == email_introducido && user != id_maestro_introducido){
                        swal("Error", "El email ya existe, intentelo de nuevo","error");
                        if(user != ""){
                            $('#email').val(email_maestro);
                        } else {
                            $('#email').val("");
                        }
                    }
                },
                error:function() {
                    swal("Error", "Ha ocurrido un error intentelo de nuevo","error");                
                }
            });
        }else {
            swal("Cuidado","El campo de email está vacío","warning");
        }
    }
    /* Funcion para corroborar si el telefono ya existe en la base de datos */
    function VerificaMaestroTelefono(){
        var telefono = $('#telefono').val();
        var user     = $('#id_user').val();
        if(telefono != ""){
            $.ajax({
                url:    myBase_url+"index.php/Maestros/CheckTelefonoExistente",
                type:   'POST',
                data:   {telefono:telefono,id_maestro:user},
                async:  true,
                success:function(datos){
                    var obj                 = JSON.parse(datos);
                    var datosPadre          = obj['telefonoP'];
                    var datosMaestro        = obj['telefonoM'];
                    var telefono_maestro    = obj['id'][0].telefono;                    
                    if (datosMaestro != ""){
                        var telefonoM_introducido  = obj['telefonoM'][0].telefono;
                        var id_maestro_introducido = obj['telefonoM'][0].id_padre;
                        if (telefono_maestro == ""){
                            swal("Error", "El telefono ya existe, intentelo de nuevo","error");
                            $('#telefono').val("");
                        }
                        else {
                            if(telefono == telefono_maestro){
                            }
                            else if(telefono == telefonoM_introducido && user != id_maestro_introducido){
                                swal("Error", "El telefono ya existe, intentelo de nuevo","error");
                                if(user != ""){
                                    $('#telefono').val(telefono_maestro);
                                } else {
                                    $('#telefono').val("");
                                }
                            }
                        }
                    }
                    else if(datosPadre != ""){
                        var telefonoP_introducido = obj['telefonoP'][0].telefono;
                        var id_padre_introducido  = obj['telefonoP'][0].id_padre;
                        if (telefono_maestro == ""){
                            swal("Error", "El telefono ya existe, intentelo de nuevo","error");
                            $('#telefono').val("");
                        }
                        else {
                            if(telefono == telefono_maestro){
                            }
                            else if(telefono == telefonoP_introducido && user != id_padre_introducido){
                                swal("Error", "El telefono ya existe, intentelo de nuevo","error");
                                if(user != ""){
                                    $('#telefono').val(telefono_maestro);
                                } else {
                                    $('#telefono').val("");
                                }
                            }
                        }
                    }
                },
                error:function() {
                    swal("Error", "Ha ocurrido un error intentelo de nuevo","error");                
                }
            });
        }
    }
    function GuardarMaestro(){
        var nombre      = $('#nombre').val();
        var apaterno    = $('#apaterno').val();
        var amaterno    = $('#amaterno').val();
        var telefono    = $('#telefono').val();
        var direccion   = $('#direccion').val();
        var email       = $('#email').val();
        var username    = $('#username').val();
        var password    = $('#password').val();
        var nivel          = $('#nivel').val();

        if(nombre != "" && apaterno != "" && amaterno != "" && telefono != "" && direccion != "" && email != "" && username != "" && password != "" && nivel != ""){
            $.ajax({
                url:     myBase_url+"index.php/Maestros/SaveMaestro",
                type:    'POST',
                data:    {nombre:nombre,apaterno:apaterno,amaterno:amaterno,telefono:telefono,direccion:direccion,email:email,username:username,password:password, nivel:nivel},
                async:   true,
                success: function(datos){
                    swal({
                        title:              "Exito",
                        text:               "Se ha guardado el maestro con exito",
                        type:               "success",
                        showCancelButton:   false,
                        confirmButtonColor: "#DD6B55",
                        confirmButtonText:  "OK",
                        cancelButtonText:   "No, Cancelar",
                        closeOnConfirm:     true,
                        closeOnCancel:      false
                    }, function(isConfirm){
                        location.href = "";
                    });
                },
            });
        }else{
            swal("Cuidado","Aun existen campos vacios","warning");
        }
    }
    function EditarMaestro($id){
        var id = $id;
        $.ajax({
            url:    myBase_url+"index.php/Maestros/MaestroPorId",
            type:   'POST',
            data:   {id:id},
            async:  true,
            success:function(datos){
                var obj          = JSON.parse(datos);
                var id           = obj[0].id_maestro;
                var nombre       = obj[0].nombre;
                var apaterno     = obj[0].apaterno;
                var amaterno     = obj[0].amaterno;
                var telefono     = obj[0].telefono;
                var direccion    = obj[0].direccion;
                var email        = obj[0].email;
                var usuario      = obj[0].username;
                var password     = obj[0].password;
                var role         = obj[0].role;
                var estado       = obj[0].estado;
                var nivel        = obj[0].nivel;
                
                $('#username').attr('disabled',true);
                $('#password').attr('disabled',true);
                $('#btn-guardar').hide();
                $('#btn-cancel').show();
                $('#btn-update').show();
                $('#div-estado').show();

                $('#id_user').val(id);
                $('#nombre').val(nombre);
                $('#apaterno').val(apaterno);
                $('#amaterno').val(amaterno);
                $('#telefono').val(telefono);
                $('#direccion').val(direccion);
                $('#email').val(email);
                $('#username').val(usuario);
                $('#password').val(password);
                $('#role').val(role);
                $('#estado').val(estado);
                $('#nivel').val(nivel);
            },
            error:function() {
                swal("Error", "Ha ocurrido un error intentelo de nuevo","error");            
            }
        });
    }
    function BorrarMaestro($id){
        var id = $id;
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
        },function(isConfirm){
            if(isConfirm){
                var id = $id;
                $.ajax({
                    url:     myBase_url+"index.php/Maestros/DeleteMaestro",
                    type:    'POST',
                    data:    {id:id},
                    async:   true,
                    success: function(datos){
                        swal({
                            title:              "Exito",
                            text:               "Se ha borrado el maestro con exito",
                            type:               "success",
                            showCancelButton:   false,
                            confirmButtonColor: "#DD6B55",
                            confirmButtonText:  "OK",
                            cancelButtonText:   "No, Cancelar",
                            closeOnConfirm:     true,
                            closeOnCancel:      false
                        }, function(isConfirm){
                            location.href = "";
                        });
                    },
                    error:function() {
                        swal("Error", "Ha ocurrido un error intentelo de nuevo","error");
                        
                    }
                });
            }
        });
    }
    function ActualizarMaestro(){
        var id          = $('#id_user').val();
        var nombre      = $('#nombre').val();
        var apaterno    = $('#apaterno').val();
        var amaterno    = $('#amaterno').val();
        var telefono    = $('#telefono').val();
        var direccion   = $('#direccion').val();
        var email       = $('#email').val();
        var username    = $('#username').val();
        var password    = $('#password').val();
        var role        = $('#role').val();
        var estado      = $('#estado').val();
        var nivel       = $('#nivel').val();

        if(id != "" && nombre != "" && apaterno != "" && amaterno != "" && telefono != "" && direccion != "" && email != "" && username != "" && password != "" && role != "" && estado != "" && nivel != ""){
            $.ajax({
                url:    myBase_url+"index.php/Maestros/UpdateMaestro",
                type:   'POST',
                data:   {id:id,nombre:nombre,apaterno:apaterno,amaterno:amaterno,telefono:telefono,direccion:direccion,email:email,username:username,password:password,role:role,estado:estado,nivel:nivel},
                async:  true,
                success:function(datos){
                    swal({
                        title:              "Exito",
                        text:               "Se ha actualizado el maestro con exito",
                        type:               "success",
                        showCancelButton:   false,
                        confirmButtonColor: "#DD6B55",
                        confirmButtonText:  "OK",
                        cancelButtonText:   "No, Cancelar",
                        closeOnConfirm:     true,
                        closeOnCancel:      false
                    }, function(isConfirm){
                        location.href = "";
                    });
                },
                error:function() {
                    swal("Error", "Ha ocurrido un error intentelo de nuevo","error");
                },
            });
        }else{
            swal("Cuidado","Aun existen campos vacios","warning");
        }
    }
    /* Vaciar los campos */
    function CancelarActualizacionMaestro(){
        $('#username').attr('disabled',false);
        $('#password').attr('disabled',false);
        $('#btn-guardar').show();
        $('#btn-cancel').hide();
        $('#btn-update').hide();
        $('#div-estado').hide();

        $('#id_user').val("");
        $('#nombre').val("");
        $('#apaterno').val("");
        $('#amaterno').val("");
        $('#telefono').val("");
        $('#direccion').val("");
        $('#email').val("");
        $('#username').val("");
        $('#password').val("");
        $('#role').val("");
        $('#estado').val("");
        $('#nivel').val("");
    }
/* END - CONTROLLER: Maestros */
/* ========================== */

/* =========================== */
/* START - CONTROLLER Reportes*/
    function PadresActivos(){     
        $("#preloader").show();
        $("#botonPDF").attr('disabled', true);    
        $.ajax({
            url:     myBase_url+"index.php/Reportes/PadresActivos",
            type:    'POST',
            async:   false,
            success: function(datos){    
                datospadres = datos;
                console.log(datospadres);    
            },
            error:function (){
                swal("Error","Ha ocurrido un error intentelo de nuevo","error");
            }
        });     
        var objpadres = JSON.parse(datospadres);     
        //Funcion para construir la tabla dinamicamente
        function buildTableBody(datospadres, columns) {     
            var body = [];     
            body.push(columns);     
            datospadres.forEach(function(row) {
                var dataRow = [];
        
                columns.forEach(function(column) {
                    dataRow.push(row[column].toString());
                })
        
                body.push(dataRow);
            });     
            return body;
        }
        //Terminauncion para construir la tabla dinamicamente

        //Funcion para construir y estilar la tabla en el formato requerido por PDFmake
        function tablescitas(datospadres, columns) {
            return {
                style: 'tablecitas',
                table: {
                    widths:     ['auto','auto', 'auto', 'auto'],
                    headerRows: 1,
                    body:       buildTableBody(datospadres, columns)
                }
            };
        }
        //Termina funcion para construir y estilar la tabla en el formato requerido por PDFmake

        //Funcion para cambiar los nombres de los valores del JSON para imprimirlos en la tabla
        var objrenombradopadres = objpadres.map( item => {
            return {Nombre: item.nombre + ' ' + item.apaterno + ' ' + item.amaterno, Telefono: item.telefono, Email: item.email, Direccion: item.direccion};
        });
    
        var docDefinition = {    
            //Inicio del contenido del PDF
            content: [
                {
                    text: 'Lista de Padres Activos', style:'header',alignment:'center'
                },
                {
                    text: '\t\t\t\t\t\t\t\t\t\t\t\t', style: 'negro',alignment:'center'
                },
                {
                    text: '\t\t\t\t\t\t\t\t\t\t\t\t', style: 'negro',alignment:'center'
                },
                {
                    text: '\t\t\t\t\t\t\t\t\t\t\t\t', style: 'negro',alignment:'center'
                },
                tablescitas(objrenombradopadres, ['Nombre', 'Telefono', 'Email', 'Direccion']),
                {
                    text: '\t\t\t\t\t\t\t\t\t\t\t\t', style: 'negro',alignment:'center'
                },     
                {
                    text: '\t\t\t\t\t\t\t\t\t\t\t\t', style: 'negro',alignment:'center'
                },
                {
                    text: '\t\t\t\t\t\t\t\t\t\t\t\t', style: 'negro',alignment:'center'
                },
                {
                    text: '\t\t\t\t\t\t\t\t\t\t\t\t', style: 'negro',alignment:'center'
                }
            ], //Termina contenido del PDF
        
            //Inician estilos del PDF
            styles: {
                header: {
                    fontSize: 16,
                    bold: true
                },

                titulos: {
                    fontSize: 14,
                    bold: true,
                    decoration: 'underline',
                    alignment: 'center'
                },

                negro:{
                    bold:true,
                    fontSize: 12
                },
                tablecitas: {
                    margin: [5, 5, 0, 15],
                    fontSize: 12
                },

                especial: {
                    margin: [10, 20, 0, 0],
                    fontSize: 12
                },
                especialnegro: {
                    bold:true,
                    margin: [10, 20, 0, 0],
                    fontSize: 12
                },

            },
            //Terminan los estilos del PDF
        };     
        pdfMake.createPdf(docDefinition).download("Reporte de Citas de Clientes Activos"); //Crea y descarga el PDF con el numero dela visita
        //pdfMake.createPdf(docDefinition).open(); //Abre el PDF en el navegador    
        $("#preloader").hide();
        $("#botonPDF").attr('disabled',false);     
        //Termina funcion para cambiar los nombres de los valores del JSON para imprimirlos en la tabla
    }
    function AlumnosActivos(){     
        $("#preloader").show();
        $("#botonPDF").attr('disabled', true);    
        $.ajax({
            url:     myBase_url+"index.php/Reportes/AlumnosActivos",
            type:    'POST',
            async:   false,
            success: function(datos){    
                datosalumnos = datos;
                console.log(datosalumnos);
            },
            error:function (){
                swal("Error","Ha ocurrido un error intentelo de nuevo","error");
            }
        });     
        var objalumnos = JSON.parse(datosalumnos);     
        //Funcion para construir la tabla dinamicamente
        function buildTableBody(datosalumnos, columns) {     
            var body = [];     
            body.push(columns);     
            datosalumnos.forEach(function(row) {
                var dataRow = [];
        
                columns.forEach(function(column) {
                    dataRow.push(row[column].toString());
                })
        
                body.push(dataRow);
            });     
            return body;
        }
        //Terminauncion para construir la tabla dinamicamente

        //Funcion para construir y estilar la tabla en el formato requerido por PDFmake
        function tablescitas(datosalumnos, columns) {
            return {
                style: 'tablecitas',
                table: {
                    widths:     ['auto','auto', 'auto', 'auto'],
                    headerRows: 1,
                    body:       buildTableBody(datosalumnos, columns)
                }
            };
        }
        //Termina funcion para construir y estilar la tabla en el formato requerido por PDFmake

        //Funcion para cambiar los nombres de los valores del JSON para imprimirlos en la tabla
        var objrenombradoalumnos = objalumnos.map( item => {
            return {Nombre: item.nombre_nino + ' ' + item.apaterno_nino + ' ' + item.amaterno_nino, Telefono: item.tel_emergencia, Nivel: item.nivel, Padre: item.nombre + ' ' + item.apaterno + ' ' + item.amaterno};
        });    
        var docDefinition = {    
            //Inicio del contenido del PDF
            content: [
                {
                    text: 'Lista de Alumnos Activos', style:'header',alignment:'center'
                },
                {
                    text: '\t\t\t\t\t\t\t\t\t\t\t\t', style: 'negro',alignment:'center'
                },
                {
                    text: '\t\t\t\t\t\t\t\t\t\t\t\t', style: 'negro',alignment:'center'
                },
                {
                    text: '\t\t\t\t\t\t\t\t\t\t\t\t', style: 'negro',alignment:'center'
                },
                tablescitas(objrenombradoalumnos, ['Nombre', 'Telefono', 'Nivel', 'Padre']),
                {
                    text: '\t\t\t\t\t\t\t\t\t\t\t\t', style: 'negro',alignment:'center'
                },     
                {
                    text: '\t\t\t\t\t\t\t\t\t\t\t\t', style: 'negro',alignment:'center'
                },
                {
                    text: '\t\t\t\t\t\t\t\t\t\t\t\t', style: 'negro',alignment:'center'
                },
                {
                    text: '\t\t\t\t\t\t\t\t\t\t\t\t', style: 'negro',alignment:'center'
                }
            ], //Termina contenido del PDF
        
            //Inician estilos del PDF
            styles: {
                header: {
                    fontSize: 16,
                    bold: true
                },

                titulos: {
                    fontSize: 14,
                    bold: true,
                    decoration: 'underline',
                    alignment: 'center'
                },

                negro:{
                    bold:true,
                    fontSize: 12
                },
                tablecitas: {
                    margin: [5, 5, 0, 15],
                    fontSize: 12
                },

                especial: {
                    margin: [10, 20, 0, 0],
                    fontSize: 12
                },
                especialnegro: {
                    bold:true,
                    margin: [10, 20, 0, 0],
                    fontSize: 12
                },
            },
            //Terminan los estilos del PDF
        };     
        pdfMake.createPdf(docDefinition).download("Reporte de Citas de Clientes Activos"); //Crea y descarga el PDF con el numero dela visita
        //pdfMake.createPdf(docDefinition).open(); //Abre el PDF en el navegador    
        $("#preloader").hide();
        $("#botonPDF").attr('disabled',false);     
        //Termina funcion para cambiar los nombres de los valores del JSON para imprimirlos en la tabla
    }
    function MaestrosActivos(){     
        $("#preloader").show();
        $("#botonPDF").attr('disabled', true);    
        $.ajax({
            url:     myBase_url+"index.php/Reportes/MaestrosActivos",
            type:    'POST',
            async:   false,
            success: function(datos){    
                datosmaestros = datos;
                console.log(datosmaestros);
            },
            error:function (){
                swal("Error","Ha ocurrido un error intentelo de nuevo","error");
            }
        });     
        var objmaestros = JSON.parse(datosmaestros);     
        //Funcion para construir la tabla dinamicamente
        function buildTableBody(datosmaestros, columns) {     
            var body = [];     
            body.push(columns);     
            datosmaestros.forEach(function(row) {
                var dataRow = [];
        
                columns.forEach(function(column) {
                    dataRow.push(row[column].toString());
                })
        
                body.push(dataRow);
            });     
            return body;
        }
        //Terminauncion para construir la tabla dinamicamente

        //Funcion para construir y estilar la tabla en el formato requerido por PDFmake
        function tablescitas(datosmaestros, columns) {
            return {
                style: 'tablecitas',
                table: {
                    widths:     ['auto','auto', 'auto', 'auto', 'auto'],
                    headerRows: 1,
                    body:       buildTableBody(datosmaestros, columns)
                }
            };
        }
        //Termina funcion para construir y estilar la tabla en el formato requerido por PDFmake

        //Funcion para cambiar los nombres de los valores del JSON para imprimirlos en la tabla
        var objrenombradomaestros = objmaestros.map( item => {
            return {Nombre: item.nombre + ' ' + item.apaterno + ' ' + item.amaterno, Telefono: item.telefono, Nivel: item.nivel, Direccion: item.direccion, Email: item.email};
        });    
        var docDefinition = {    
            //Inicio del contenido del PDF
            content: [
                {
                    text: 'Lista de Maestros Activos', style:'header',alignment:'center'
                },
                {
                    text: '\t\t\t\t\t\t\t\t\t\t\t\t', style: 'negro',alignment:'center'
                },
                {
                    text: '\t\t\t\t\t\t\t\t\t\t\t\t', style: 'negro',alignment:'center'
                },
                {
                    text: '\t\t\t\t\t\t\t\t\t\t\t\t', style: 'negro',alignment:'center'
                },
                tablescitas(objrenombradomaestros, ['Nombre', 'Telefono', 'Nivel', 'Direccion', 'Email']),
                {
                    text: '\t\t\t\t\t\t\t\t\t\t\t\t', style: 'negro',alignment:'center'
                },     
                {
                    text: '\t\t\t\t\t\t\t\t\t\t\t\t', style: 'negro',alignment:'center'
                },
                {
                    text: '\t\t\t\t\t\t\t\t\t\t\t\t', style: 'negro',alignment:'center'
                },
                {
                    text: '\t\t\t\t\t\t\t\t\t\t\t\t', style: 'negro',alignment:'center'
                },
                {
                    text: '\t\t\t\t\t\t\t\t\t\t\t\t', style: 'negro',alignment:'center'
                }
            ], //Termina contenido del PDF
        
            //Inician estilos del PDF
            styles: {
                header: {
                    fontSize: 16,
                    bold: true
                },

                titulos: {
                    fontSize: 14,
                    bold: true,
                    decoration: 'underline',
                    alignment: 'center'
                },

                negro:{
                    bold:true,
                    fontSize: 12
                },
                tablecitas: {
                    margin: [5, 5, 0, 15],
                    fontSize: 12
                },

                especial: {
                    margin: [10, 20, 0, 0],
                    fontSize: 12
                },
                especialnegro: {
                    bold:true,
                    margin: [10, 20, 0, 0],
                    fontSize: 12
                },

            },
            //Terminan los estilos del PDF
        };     
        pdfMake.createPdf(docDefinition).download("Reporte de Citas de Clientes Activos"); //Crea y descarga el PDF con el numero dela visita
        //pdfMake.createPdf(docDefinition).open(); //Abre el PDF en el navegador    
        $("#preloader").hide();
        $("#botonPDF").attr('disabled',false);     
        //Termina funcion para cambiar los nombres de los valores del JSON para imprimirlos en la tabla
    }
    function NivelesActivos(){     
        $("#preloader").show();
        $("#botonPDF").attr('disabled', true);    
        $.ajax({
            url:     myBase_url+"index.php/Reportes/NivelesActivos",
            type:    'POST',
            async:   false,
            success: function(datos){    
                datosnivel = datos;
            },
            error:function (){
                swal("Error","Ha ocurrido un error intentelo de nuevo","error");
            }
        });     
        var objnivel = JSON.parse(datosnivel);     
        //Funcion para construir la tabla dinamicamente
        function buildTableBody(datosnivel, columns) {     
            var body = [];     
            body.push(columns);     
            datosnivel.forEach(function(row) {
                var dataRow = [];
        
                columns.forEach(function(column) {
                    dataRow.push(row[column].toString());
                })
        
                body.push(dataRow);
            });     
            return body;
        }
        //Terminauncion para construir la tabla dinamicamente

        //Funcion para construir y estilar la tabla en el formato requerido por PDFmake
        function tablescitas(datosnivel, columns) {
            return {
                style: 'tablecitas',
                table: {
                    widths:     ['auto','auto', 'auto'],
                    headerRows: 1,
                    body:       buildTableBody(datosnivel, columns)
                }
            };
        }
        //Termina funcion para construir y estilar la tabla en el formato requerido por PDFmake

        //Funcion para cambiar los nombres de los valores del JSON para imprimirlos en la tabla
        var objrenombradonivel = objnivel.map( item => {
            return {Nombre: item.nombre_nino + ' ' + item.apaterno_nino + ' ' + item.amaterno_nino, Telefono: item.tel_emergencia, Nivel: item.nivel};
        });    
        var docDefinition = {    
            //Inicio del contenido del PDF
            content: [
                {
                    text: 'Lista de Alumnos de los Niveles Activos', style:'header',alignment:'center'
                },
                {
                    text: '\t\t\t\t\t\t\t\t\t\t\t\t', style: 'negro',alignment:'center'
                },
                {
                    text: '\t\t\t\t\t\t\t\t\t\t\t\t', style: 'negro',alignment:'center'
                },
                {
                    text: '\t\t\t\t\t\t\t\t\t\t\t\t', style: 'negro',alignment:'center'
                },
                tablescitas(objrenombradonivel, ['Nombre', 'Telefono', 'Nivel']),
                {
                    text: '\t\t\t\t\t\t\t\t\t\t\t\t', style: 'negro',alignment:'center'
                },
                {
                    text: '\t\t\t\t\t\t\t\t\t\t\t\t', style: 'negro',alignment:'center'
                },
                {
                    text: '\t\t\t\t\t\t\t\t\t\t\t\t', style: 'negro',alignment:'center'
                }
            ], //Termina contenido del PDF
        
            //Inician estilos del PDF
            styles: {
                header: {
                    fontSize: 16,
                    bold: true
                },

                titulos: {
                    fontSize: 14,
                    bold: true,
                    decoration: 'underline',
                    alignment: 'center'
                },

                negro:{
                    bold:true,
                    fontSize: 12
                },
                tablecitas: {
                    margin: [5, 5, 0, 15],
                    fontSize: 12
                },

                especial: {
                    margin: [10, 20, 0, 0],
                    fontSize: 12
                },
                especialnegro: {
                    bold:true,
                    margin: [10, 20, 0, 0],
                    fontSize: 12
                },
            },
            //Terminan los estilos del PDF
        };     
        pdfMake.createPdf(docDefinition).download("Reporte de Alumnos de Niveles Activos"); //Crea y descarga el PDF con el numero dela visita
        //pdfMake.createPdf(docDefinition).open(); //Abre el PDF en el navegador    
        $("#preloader").hide();
        $("#botonPDF").attr('disabled',false);     
        //Termina funcion para cambiar los nombres de los valores del JSON para imprimirlos en la tabla
    }
    function Nivel1Activos(){     
        $("#preloader").show();
        $("#botonPDF").attr('disabled', true);    
        $.ajax({
            url:     myBase_url+"index.php/Reportes/Nivel1Activos",
            type:    'POST',
            async:   false,
            success: function(datos){    
                datosnivel = datos;
            },
            error:function (){
                swal("Error","Ha ocurrido un error intentelo de nuevo","error");
            }
        });     
        var objnivel = JSON.parse(datosnivel);     
        //Funcion para construir la tabla dinamicamente
        function buildTableBody(datosnivel, columns) {     
            var body = [];     
            body.push(columns);     
            datosnivel.forEach(function(row) {
                var dataRow = [];
        
                columns.forEach(function(column) {
                    dataRow.push(row[column].toString());
                })
        
                body.push(dataRow);
            });     
            return body;
        }
        //Terminauncion para construir la tabla dinamicamente

        //Funcion para construir y estilar la tabla en el formato requerido por PDFmake
        function tablescitas(datosnivel, columns) {
            return {
                style: 'tablecitas',
                table: {
                    widths:     ['auto','auto', 'auto'],
                    headerRows: 1,
                    body:       buildTableBody(datosnivel, columns)
                }
            };
        }
        //Termina funcion para construir y estilar la tabla en el formato requerido por PDFmake

        //Funcion para cambiar los nombres de los valores del JSON para imprimirlos en la tabla
        var objrenombradonivel = objnivel.map( item => {
            return {Nombre: item.nombre_nino + ' ' + item.apaterno_nino + ' ' + item.amaterno_nino, Telefono: item.tel_emergencia, Nivel: item.nivel};
        });    
        var docDefinition = {    
            //Inicio del contenido del PDF
            content: [
                {
                    text: 'Lista de Alumnos del Nivel 1 Activos', style:'header',alignment:'center'
                },
                {
                    text: '\t\t\t\t\t\t\t\t\t\t\t\t', style: 'negro',alignment:'center'
                },
                {
                    text: '\t\t\t\t\t\t\t\t\t\t\t\t', style: 'negro',alignment:'center'
                },
                {
                    text: '\t\t\t\t\t\t\t\t\t\t\t\t', style: 'negro',alignment:'center'
                },
                tablescitas(objrenombradonivel, ['Nombre', 'Telefono', 'Nivel']),
                {
                    text: '\t\t\t\t\t\t\t\t\t\t\t\t', style: 'negro',alignment:'center'
                },
                {
                    text: '\t\t\t\t\t\t\t\t\t\t\t\t', style: 'negro',alignment:'center'
                },
                {
                    text: '\t\t\t\t\t\t\t\t\t\t\t\t', style: 'negro',alignment:'center'
                }
            ], //Termina contenido del PDF
        
            //Inician estilos del PDF
            styles: {
                header: {
                    fontSize: 16,
                    bold: true
                },

                titulos: {
                    fontSize: 14,
                    bold: true,
                    decoration: 'underline',
                    alignment: 'center'
                },

                negro:{
                    bold:true,
                    fontSize: 12
                },
                tablecitas: {
                    margin: [5, 5, 0, 15],
                    fontSize: 12
                },

                especial: {
                    margin: [10, 20, 0, 0],
                    fontSize: 12
                },
                especialnegro: {
                    bold:true,
                    margin: [10, 20, 0, 0],
                    fontSize: 12
                },
            },
            //Terminan los estilos del PDF
        };     
        pdfMake.createPdf(docDefinition).download("Reporte de Alumnos del Nivel 1 Activos"); //Crea y descarga el PDF con el numero dela visita
        //pdfMake.createPdf(docDefinition).open(); //Abre el PDF en el navegador    
        $("#preloader").hide();
        $("#botonPDF").attr('disabled',false);     
        //Termina funcion para cambiar los nombres de los valores del JSON para imprimirlos en la tabla
    }
    function Nivel2Activos(){     
        $("#preloader").show();
        $("#botonPDF").attr('disabled', true);    
        $.ajax({
            url:     myBase_url+"index.php/Reportes/Nivel2Activos",
            type:    'POST',
            async:   false,
            success: function(datos){    
                datosnivel = datos;
            },
            error:function (){
                swal("Error","Ha ocurrido un error intentelo de nuevo","error");
            }
        });     
        var objnivel = JSON.parse(datosnivel);     
        //Funcion para construir la tabla dinamicamente
        function buildTableBody(datosnivel, columns) {     
            var body = [];     
            body.push(columns);     
            datosnivel.forEach(function(row) {
                var dataRow = [];        
                columns.forEach(function(column) {
                    dataRow.push(row[column].toString());
                })        
                body.push(dataRow);
            });     
            return body;
        }
        //Terminauncion para construir la tabla dinamicamente

        //Funcion para construir y estilar la tabla en el formato requerido por PDFmake
        function tablescitas(datosnivel, columns) {
            return {
                style: 'tablecitas',
                table: {
                    widths:     ['auto','auto', 'auto'],
                    headerRows: 1,
                    body:       buildTableBody(datosnivel, columns)
                }
            };
        }
        //Termina funcion para construir y estilar la tabla en el formato requerido por PDFmake

        //Funcion para cambiar los nombres de los valores del JSON para imprimirlos en la tabla
        var objrenombradonivel = objnivel.map( item => {
            return {Nombre: item.nombre_nino + ' ' + item.apaterno_nino + ' ' + item.amaterno_nino, Telefono: item.tel_emergencia, Nivel: item.nivel};
        });    
        var docDefinition = {    
            //Inicio del contenido del PDF
            content: [
                {
                    text: 'Lista de Alumnos del Nivel 2 Activos', style:'header',alignment:'center'
                },
                {
                    text: '\t\t\t\t\t\t\t\t\t\t\t\t', style: 'negro',alignment:'center'
                },
                {
                    text: '\t\t\t\t\t\t\t\t\t\t\t\t', style: 'negro',alignment:'center'
                },
                {
                    text: '\t\t\t\t\t\t\t\t\t\t\t\t', style: 'negro',alignment:'center'
                },
                tablescitas(objrenombradonivel, ['Nombre', 'Telefono', 'Nivel']),
                {
                    text: '\t\t\t\t\t\t\t\t\t\t\t\t', style: 'negro',alignment:'center'
                },
                {
                    text: '\t\t\t\t\t\t\t\t\t\t\t\t', style: 'negro',alignment:'center'
                },
                {
                    text: '\t\t\t\t\t\t\t\t\t\t\t\t', style: 'negro',alignment:'center'
                }
            ], //Termina contenido del PDF
        
            //Inician estilos del PDF
            styles: {
                header: {
                    fontSize: 16,
                    bold: true
                },

                titulos: {
                    fontSize: 14,
                    bold: true,
                    decoration: 'underline',
                    alignment: 'center'
                },

                negro:{
                    bold:true,
                    fontSize: 12
                },
                tablecitas: {
                    margin: [5, 5, 0, 15],
                    fontSize: 12
                },

                especial: {
                    margin: [10, 20, 0, 0],
                    fontSize: 12
                },
                especialnegro: {
                    bold:true,
                    margin: [10, 20, 0, 0],
                    fontSize: 12
                },
            },
            //Terminan los estilos del PDF
        };     
        pdfMake.createPdf(docDefinition).download("Reporte de Alumnos del Nivel 2 Activos"); //Crea y descarga el PDF con el numero dela visita
        //pdfMake.createPdf(docDefinition).open(); //Abre el PDF en el navegador    
        $("#preloader").hide();
        $("#botonPDF").attr('disabled',false);     
        //Termina funcion para cambiar los nombres de los valores del JSON para imprimirlos en la tabla
    }
    function Nivel3Activos(){     
        $("#preloader").show();
        $("#botonPDF").attr('disabled', true);    
        $.ajax({
            url:     myBase_url+"index.php/Reportes/Nivel3Activos",
            type:    'POST',
            async:   false,
            success: function(datos){    
                datosnivel = datos;
            },
            error:function (){
                swal("Error","Ha ocurrido un error intentelo de nuevo","error");
            }
        });     
        var objnivel = JSON.parse(datosnivel);     
        //Funcion para construir la tabla dinamicamente
        function buildTableBody(datosnivel, columns) {     
            var body = [];     
            body.push(columns);     
            datosnivel.forEach(function(row) {
                var dataRow = [];        
                columns.forEach(function(column) {
                    dataRow.push(row[column].toString());
                })        
                body.push(dataRow);
            });     
            return body;
        }
        //Terminauncion para construir la tabla dinamicamente

        //Funcion para construir y estilar la tabla en el formato requerido por PDFmake
        function tablescitas(datosnivel, columns) {
            return {
                style: 'tablecitas',
                table: {
                    widths:     ['auto','auto', 'auto'],
                    headerRows: 1,
                    body:       buildTableBody(datosnivel, columns)
                }
            };
        }
        //Termina funcion para construir y estilar la tabla en el formato requerido por PDFmake

        //Funcion para cambiar los nombres de los valores del JSON para imprimirlos en la tabla
        var objrenombradonivel = objnivel.map( item => {
            return {Nombre: item.nombre_nino + ' ' + item.apaterno_nino + ' ' + item.amaterno_nino, Telefono: item.tel_emergencia, Nivel: item.nivel};
        });
    
        var docDefinition = {    
            //Inicio del contenido del PDF
            content: [
                {
                    text: 'Lista de Alumnos del Nivel 3 Activos', style:'header',alignment:'center'
                },
                {
                    text: '\t\t\t\t\t\t\t\t\t\t\t\t', style: 'negro',alignment:'center'
                },
                {
                    text: '\t\t\t\t\t\t\t\t\t\t\t\t', style: 'negro',alignment:'center'
                },
                {
                    text: '\t\t\t\t\t\t\t\t\t\t\t\t', style: 'negro',alignment:'center'
                },
                tablescitas(objrenombradonivel, ['Nombre', 'Telefono', 'Nivel']),
                {
                    text: '\t\t\t\t\t\t\t\t\t\t\t\t', style: 'negro',alignment:'center'
                },
                {
                    text: '\t\t\t\t\t\t\t\t\t\t\t\t', style: 'negro',alignment:'center'
                },
                {
                    text: '\t\t\t\t\t\t\t\t\t\t\t\t', style: 'negro',alignment:'center'
                }
            ], //Termina contenido del PDF
        
            //Inician estilos del PDF
            styles: {
                header: {
                    fontSize: 16,
                    bold: true
                },

                titulos: {
                    fontSize: 14,
                    bold: true,
                    decoration: 'underline',
                    alignment: 'center'
                },

                negro:{
                    bold:true,
                    fontSize: 12
                },
                tablecitas: {
                    margin: [5, 5, 0, 15],
                    fontSize: 12
                },

                especial: {
                    margin: [10, 20, 0, 0],
                    fontSize: 12
                },
                especialnegro: {
                    bold:true,
                    margin: [10, 20, 0, 0],
                    fontSize: 12
                },
            },
            //Terminan los estilos del PDF
        };     
        pdfMake.createPdf(docDefinition).download("Reporte de Alumnos del Nivel 3 Activos"); //Crea y descarga el PDF con el numero dela visita
        //pdfMake.createPdf(docDefinition).open(); //Abre el PDF en el navegador    
        $("#preloader").hide();
        $("#botonPDF").attr('disabled',false);     
        //Termina funcion para cambiar los nombres de los valores del JSON para imprimirlos en la tabla
    }
/* END - CONTROLLER Reportes*/ 
/* ========================= */