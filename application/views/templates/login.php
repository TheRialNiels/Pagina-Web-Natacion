<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Dosis:wght@200;500;700;800&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous">

        <!meta http-equiv="X-UA-Compatible" content="IE=edge">
        <!meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="Sistema de Tienda Virtual">
        <meta name="author" content="Daniel Alexis Martinez Sosa">

        <title><?= $tabTitle; ?></title>

        <?php
        /* Dependencias requeridas para el funcionamiento del LOGIN */
        /* ==============================================================
                <---  CSS TEMPLATE  --->
           ============================================================== */

            echo link_tag('assets/login/main.css');
            echo link_tag('assets/login/normalize.css');

            echo link_tag('assets/darktemplate/css/components.css');
            echo link_tag('assets/darktemplate/css/icons.css');
            echo link_tag('assets/darktemplate/css/pages.css');
            echo link_tag('assets/darktemplate/css/responsive.css');
            echo link_tag('assets/darktemplate/plugins/bootstrap-sweetalert/sweet-alert.css');

        /* ==============================================================
                <---  JS TEMPLATE  --->
           ============================================================== */
            echo script_tag("assets/darktemplate/plugins/bootstrap-sweetalert/sweet-alert.js");
            echo script_tag("assets/darktemplate/js/jquery.min.js");
            echo script_tag("assets/darktemplate/js/bootstrap.min.js");
            echo script_tag('assets/darktemplate/js/fastclick.js');
            echo script_tag("assets/darktemplate/plugins/bootstrap-sweetalert/sweet-alert.js");
            echo script_tag("assets/darktemplate/pages/jquery.sweet-alert.init.js");
            
        /* ==============================================================
                <---  JS MYAPP  --->
           ============================================================== */
            echo script_tag("assets/myapp/js/MY_Functions.js");
        ?>
        
        <script type="text/javascript">
            //var resizefunc = [];
            var myBase_url = '<?php echo base_url();?>';

            $(document ).ready(function() {
                //alert($().jquery);

                window.location.hash="no-back-button";
                window.location.hash="Again-No-back-button" //chrome
                window.onhashchange=function(){window.location.hash="no-back-button";}

                $("#registro").hide();
                $("#resettab").hide();
              

            });

            function ShowPanel(){

                $("#registro").show();
                $("#logintab").hide();
            }

            function ShowPanelReset(){

              $("#resettab").show();
              $("#logintab").hide();
              
            }

            function CheckPass(){

              var pass = $("#pass").val();
              var pass1 = $("#pass1").val();

              if(pass != pass1){

                $("#pass").val("");
                $("#pass1").val("");
                swal("Cuidado","Las contraseñas no coinciden","warning");
              }

            }

        </script>

        <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">
        <script src="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>
    </head>

    <body>        
        <main class="login-design">            
            <div class="waves" style="background-image: url(<?php echo base_url("assets/login/img/wave_azul.png") ?>)">
                <img src="<?php echo base_url("assets/login/img/LogoBis.png") ?>" alt="">
            </div>
            <div class="login" id="lo">
                
                <div class="login-data" id="logintab">
                    <img src="<?php echo base_url("assets/login/img/logo_natacion.png") ?>" alt="">
                    <h1>Log in</h1>
                    <form class="form-horizontal" action="#" id="inicio">
                        <div class="input-group">
                            <label class="input-fill">
                                <input class="form-control" type="text" id="user" required="" placeholder="Usuario">
                                <span class="input-label">Usuario</span>
                                <i class="fas fa-envelope"></i>
                            </label>
                        </div>
                        <div class="input-group">
                            <label class="input-fill">
                                <input class="form-control" type="password" id="password" onkeypress="return verifyenterkeypressed(event)" placeholder="Contraseña">
                                <span class="input-label">Contraseña</span>
                                <i class="fas fa-lock"></i>
                            </label>
                        </div>
                        <div class="input-group">
                            <div id="fountainTextG" hidden="true" align="center">                                
                                <img src="<?php echo base_url('assets/myapp/img/preloader2.gif'); ?>" alt="validando...">
                            </div>
                        </div>
                        <button onClick="validateuserlogin();" class="btn-login">Entrar</button>

                            <br>
                            <br>

                        <button class="btn-login" onClick="ShowPanelReset();">Reseteo de Sesion</button>
                    </form>
                </div>
                <div class="login-data" id="resettab">
                    <img src="<?php echo base_url("assets/login/img/logo_natacion.png") ?>" alt="">
                    <h1>Reset Session</h1>
                    <div class="input-group">
                        <label class="input-fill">
                            <input class="form-control" type="text" required="" id="userreset">
                            <span class="input-label">Usuario</span>
                            <i class="fas fa-envelope"></i>
                        </label>
                    </div>

                    <div class="input-group">
                        <label class="input-fill">
                            <input class="form-control" type="password" required="" id="passwordreset">
                            <span class="input-label">Password</span>
                            <i class="fas fa-lock"></i>
                        </label>
                    </div>
                    <button href="#" onClick="ResetUserLogin();" class="btn-login">Reset</button>
                </div>
            </div>
        </main>
    </body>
</html>


   