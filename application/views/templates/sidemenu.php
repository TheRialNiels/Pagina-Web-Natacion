========== Left Sidebar Start ========== -->

            <?php $rol = ($this->session->userdata('tipo_user'));

            echo "<script languaje='JavaScript'>
                
                $( document ).ready(function() {
                var roles= '$rol';

                switch(roles) {

                    case 'Padre':

                        break;
                        
                    case 'Maestro':

                        
                    
                        break;

                    case 'Nino':

                    break;
                        
                }
                
            });
                             
            </script>";
            ?>
        
            <!-- <div class="left side-menu" id="master" >
                <div class="sidebar-inner slimscrollleft">
                    
                    <div id="sidebar-menu" >
                        <ul id="todo">
                            <li class="text-muted menu-title" style="color:black;">Menu</li>
                            <li class="has_sub" id="padres">
                                <a href="<?= base_url('index.php/Dashboard/');?>" class="waves-effect waves-light" style="color:black;"><i class="fa fa-bank "></i><span> Dashboard</span> </a>
                            </li>
                            <li class="has_sub" id="padres">
                                <a href="<?= base_url('index.php/Padres/');?>" class="waves-effect waves-light" style="color:black;"><i class="fa fa-bank "></i><span> Padres</span> </a>
                            </li>

                            <li class="has_sub" id="alumnos">
                                <a href="<?= base_url('index.php/Alumnos/');?>" class="waves-effect waves-light" style="color:black;"><i class="fa fa-bank "></i><span> Alumnos</span> </a>
                            </li>

                            <li class="has_sub" id="maestros">
                                <a href="<?= base_url('index.php/Maestros/');?>" class="waves-effect waves-light" style="color:black;"><i class="fa fa-bank "></i><span> Maestros</span> </a>
                            </li>
                            <li class="has_sub" id="calendario">
                                <a href="<?= base_url('index.php/Calendario/');?>" class="waves-effect waves-light" style="color:black;"><i class="fa fa-bank "></i><span> Calendario</span> </a>
                            </li>
                            <li class="has_sub" id="calendariomaestros">
                                <a href="<?= base_url('index.php/CalendarioMaestros/');?>" class="waves-effect waves-light" style="color:black;"><i class="fa fa-bank "></i><span> Calendario Maestros</span> </a>
                            </li>
                            <br>
                            <li class="text-muted menu-title" style="color:black;">Niveles</li>
                            <li class="has_sub" id="nivel1">
                                <a href="<?= base_url('index.php/Nivel1/');?>" class="waves-effect waves-light" style="color:black;"><i class="fa fa-bank "></i><span> Nivel 1</span> </a>
                            </li>
                            <li class="has_sub" id="nivel2">
                                <a href="<?= base_url('index.php/Nivel2/');?>" class="waves-effect waves-light" style="color:black;"><i class="fa fa-bank "></i><span> Nivel 2</span> </a>
                            </li>
                            <li class="has_sub" id="nivel3">
                                <a href="<?= base_url('index.php/Nivel3/');?>" class="waves-effect waves-light" style="color:black;"><i class="fa fa-bank "></i><span> Nivel 3</span> </a>
                            </li> -->

                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
            <!-- Left Sidebar End