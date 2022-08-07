<script type="text/javascript">
    $(document).ready(function() {    
        var tiempo = setTimeout(LogOut,900000);
        CheckUActivo();
        document.addEventListener("click", function() {
            clearTimeout(tiempo);
            tiempo = setTimeout(LogOut, 900000);
        })
    });
</script>

<body class="fixed-left">
    <?= $tipo_user = $this->session->userdata('tipo_user');?>
    <div id="wrapper"><!-- Begin page -->
        <div class="topbar"><!-- Top Bar Start -->
            <div class="topbar-left" ><!-- LOGO -->
                <div class="text-center">                    
                    <a href="<?= base_url('index.php/Dashboard/');?>" class="logo"><img src="<?php echo base_url('assets/myapp/img/logo.png'); ?>" alt="Logo" class="img-circle" height="65px"></a>                    
                </div>
            </div>          
                
            <div class="navbar navbar-default" role="navigation"><!-- Button mobile view to collapse sidebar menu -->
                <div class="container bg-info">
                    <ul class="nav navbar-nav navbar-right pull-left">
                        <li class="has_sub  text-white" id="padres">
                            <a href="#" class="waves-effect"><span><i><?php print_r($this->session->userdata('name')); ?></i></span></a>
                        </li>                        
                    </ul>

                    <ul class="nav navbar-nav navbar-right pull-right">
                        <li class="hidden-xs hidden-sm hidden-md">                        
                        </li>
                        <li class="hidden-xs hidden-sm">                        
                        
                        <?php if($tipo_user == 'Admin') { ?>
                            <li class="has_sub  text-white" id="padres">
                                <a href="<?= base_url('index.php/Padres/');?>" class="waves-effect waves-light" style="color:black;">
                                    <i class='fa-solid fa-person '></i>
                                    <span> Padres</span> 
                                </a>
                            </li>
                            <li class="has_sub" id="alumnos">
                                <a href="<?= base_url('index.php/Alumnos/');?>" class="waves-effect waves-light" style="color:black;"><i class="fa-solid fa-person-swimming "></i><span> Alumnos</span> </a>
                            </li>
                            <li class="has_sub" id="maestros">
                                <a href="<?= base_url('index.php/Maestros/');?>" class="waves-effect waves-light" style="color:black;"><i class="fas fa-chalkboard-teacher "></i><span> Maestros</span> </a>
                            </li>
                        <?php } ?>                        

                        <?php if($tipo_user == 'Padre') { ?>
                            <li class="has_sub" id="calendario">
                                <a href="<?= base_url('index.php/Calendario/');?>" class="waves-effect waves-light" style="color:black;"><i class="fa-solid fa-calendar-days "></i><span> Calendario</span> </a>
                            </li>
                        <?php } ?>
                        
                        <?php if($tipo_user == 'Maestro') { ?>
                            <li class="has_sub" id="calendario">
                                <a href="<?= base_url('index.php/CalendarioMaestros/');?>" class="waves-effect waves-light" style="color:black;"><i class='fa fa-calendar-o'></i><span> Calendario Maestros</span> </a>
                            </li>
                        <?php } ?>                        

                        <?php if($tipo_user == 'Admin') { ?>
                        <li class="dropdown" id="todo1">
                            <a href="" class="dropdown-toggle profile waves-effect" data-toggle="dropdown" aria-expanded="true"> <i class='fas fa-grip-lines'></i><span>  <span> Niveles</span> </a>
                            <ul class="dropdown-menu">
                                <li ><a href="<?php echo base_url('index.php/Niveles/'); ?>"><i class=" m-r-5"></i> Todos los niveles</a></li>

                                <li ><a href="<?php echo base_url('index.php/Nivel1/'); ?>"><i class=" m-r-5"></i> Nivel 1</a></li>                           
                            
                                
                                <li ><a href="<?php echo base_url('index.php/Nivel2/'); ?>"><i class=" m-r-5"></i> Nivel 2</a></li>                          

                                                            
                                <li ><a href="<?php echo base_url('index.php/Nivel3/'); ?>"><i class=" m-r-5"></i> Nivel 3</a></li>
                            </ul>
                        </li>
                        <?php } ?>
                        
                        <li class="dropdown" id="todo1">
                            <a href="" class="dropdown-toggle profile waves-effect" data-toggle="dropdown" aria-expanded="true"><img src="<?php echo base_url('assets/darktemplate/images/users/avatar.jpg'); ?>" alt="user-img" class="img-circle"> </a>
                            <ul class="dropdown-menu">                                
                                <li ><a href="<?php echo base_url('index.php/Session/logout'); ?>"><i class="ti-power-off m-r-5"></i> Cerrar sesi&oacute;n</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </div><!-- Top Bar End -->
    </div>
</body>