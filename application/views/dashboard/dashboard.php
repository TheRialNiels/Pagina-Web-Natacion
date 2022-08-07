<!-- Content Wrapper. Contains page content -->

<?php
/* Dependencias requeridas para el funcionamiento de la DataTable */
  /*  ==============================================================
                  <---  CSS TEMPLATE  --->
      ============================================================== */
      echo link_tag('assets/darktemplate/plugins/bootstrap-sweetalert/sweet-alert.css');
  /*  ==============================================================
                  <---  JS TEMPLATE  --->
      ============================================================== */
      echo script_tag("assets/darktemplate/plugins/bootstrap-sweetalert/sweet-alert.js");
      echo script_tag("assets/darktemplate/pages/jquery.sweet-alert.init.js");
  /*  ==============================================================
                  <---  JS MYAPP  --->
      ============================================================== */
        echo script_tag("assets/myapp/js/MY_Functions.js");
?>
<html>
  <head>
      <meta charset="utf-8">
      <link rel="stylesheet" type="text/css" href="<?= base_url();?>/assets/myapp/css/dashboard.css" media="screen" />
  </head>
  <script>
      var resizefunc = [];
      $(document).ready(function() {
      });
  </script>
  <body class="fixed-left">
    <!-- Begin page -->
    <div id="wrapper">
      <!-- Start content -->
      <div class="content">
        <div class="container">
          <!-- Page-Title -->
          <section id="page-title">
            <div class="row">
              <div class="col-sm-12">
                <br>
                <br>
                <br>
                <h4 class="page-title">Inicio</h4>
              </div>
            </div>
            <br>
            <br>
          </section>
          <div class="col-lg-12">
            <div class="panel panel-border panel-info">
              <div class="table-responsive">
                <!-- Panel Title -->
                <div class="panel-heading">
                  <h3 class="panel-title">Bienvenido!</h3>
                </div>
                <!-- Jumbotron -->
                <div class="panel-body">
                  <div class="jumbotron" style="background-image: url('<?= base_url() ?>/assets/myapp/img/dashboard/Natacion.jpg'); background-position: center; color: white; text-shadow: 2px 2px black;">
                    <h1>Bienvenidos a nuestras clases de natacion!</h1>
                    <p>
                      Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam placerat neque fermentum enim sollicitudin finibus. 
                      Integer tincidunt sed felis in aliquet. Ut at ullamcorper risus. Aliquam consectetur felis nec ullamcorper malesuada. 
                      Nunc dictum ornare arcu in bibendum. Integer pharetra imperdiet ex sed volutpat. Vestibulum efficitur magna nibh, 
                      ut semper arcu euismod eget. Nulla id ante arcu. Donec faucibus tempor odio a ullamcorper. Suspendisse rhoncus magna efficitur 
                      ligula eleifend, nec accumsan velit laoreet. Praesent tempus felis in vulputate egestas. Suspendisse finibus sagittis massa, ac 
                      tristique ipsum elementum non. Proin convallis venenatis varius.
                    </p>
                    <p><a class="btn btn-primary btn-lg" href="#footer" role="button">Sobre nosotros</a></p>
                  </div>
                  <!-- Features --> 
                  <section id="features">
                    <!-- #1 -->
                    <div class="media" style="padding: 1.25rem; font-size: 24px;">
                      <div class="media-left">
                        <a href="#">
                          <img class="media-object" src="<?= base_url() ?>/assets/myapp/img/dashboard/descarga.jpg" style="width: 350px;" alt="...">
                        </a>
                      </div>
                      <div class="media-body">
                        <h4 class="media-heading" style="font-size: 32px; padding: 1.25rem;">¿Cómo trabajamos? </h4>
                        <p style="text-align: left; margin-left: 10px;">
                          Con más de 20 años de experiencia, en Nadando Ando, ofrecemos clases personalizadas, de grupo, matro-natación y más.
                        </p>
                      </div>
                    </div>
                    <!-- #2 -->
                    <div class="media" style="padding: 1.25rem; font-size: 24px;">
                      <div class="media-left">
                        <a href="#">
                          <img class="media-object" src="<?= base_url() ?>/assets/myapp/img/dashboard/feature2.jpg" style="width: 350px;" alt="...">
                        </a>
                      </div>
                      <div class="media-body">
                        <h4 class="media-heading" style="font-size: 32px; padding: 1.25rem;">Maestros certificados</h4>
                        <p style="text-align: left; margin-left: 10px;">
                          Contamos con maestros certificados en la enseñanza, al igual que en primeros auxilios.
                        </p>
                      </div>
                    </div>
                    <!-- #3 -->
                    <div class="media" style="padding: 1.25rem; font-size: 24px;">
                      <div class="media-left">
                        <a href="#">
                          <img class="media-object" src="<?= base_url() ?>/assets/myapp/img/dashboard/feature3.jpg" style="width: 350px;" alt="...">
                        </a>
                      </div>
                      <div class="media-body">
                        <h4 class="media-heading" style="font-size: 32px; padding: 1.25rem;">Matro-natación:</h4>
                        <p style="text-align: left; margin-left: 10px;">
                          La matronatación es ideal para los bebés de 6 a 36 meses debido a que su sistema inmunológico ha madurado y 
                          tienen menos riesgos de padecer alguna enfermedades; además este entrenamiento permite la estimulación acuática 
                          mediante juegos para que puedan aprender a flotar y moverse por el agua, es importante que los padres siempre se 
                          encuentren presentes y puedan ayudar a sus hijos.
                        </p>
                      </div>
                    </div>
                    <!-- #4 -->
                    <div class="media" style="padding: 1.25rem; font-size: 24px;">
                      <div class="media-left">
                        <a href="#">
                          <img class="media-object" src="<?= base_url() ?>/assets/myapp/img/dashboard/feature4.jpg" style="width: 350px;" alt="...">
                        </a>
                      </div>
                      <div class="media-body">
                        <h4 class="media-heading" style="font-size: 32px; padding: 1.25rem;">Personalizado:</h4>
                        <p style="text-align: left; margin-left: 10px;">
                          Las natación es capaz de mejorar la coordinación y equilibrio de los niños, pero no es sino hasta que el aparato locomotor se 
                          encuentra los suficientemente desarrollado cuando pueden comenzar las clases de natación para niños; mientras son bebés lo principal 
                          es que aprendan a adaptarse al agua, pero cuando empiezan a poder controlar sus movimientos pueden aprender las técnicas adecuadas de natación. 
                          Por lo regular las edades de los niños abarcan desde los 3 hasta los 6 años.
                        </p>
                      </div>
                    </div>
                    <!-- #5 -->
                    <div class="media" style="padding: 1.25rem; font-size: 24px;">
                      <div class="media-left">
                        <a href="#">
                          <img class="media-object" src="<?= base_url() ?>/assets/myapp/img/dashboard/feature5.jpeg" style="width: 350px;" alt="...">
                        </a>
                      </div>
                      <div class="media-body">
                        <h4 class="media-heading" style="font-size: 32px; padding: 1.25rem;">Grupo:</h4>
                        <p style="text-align: left; margin-left: 10px;">
                          Las natación para una competencia requiere de un entrenamiento constante que desarrolle la fuerza y la velocidad; 
                          ya sea para un triatlón de atletas infantiles, juveniles o másteres, se requiere de un entrenador profesional que 
                          brinde una rutina de ejercicios que sean variados y de gran intensidad. El entrenador será el encargado de supervisar 
                          los resultados obtenidos para cambiar o mejorar las rutinas y alcanzar los objetivos del equipo.
                        </p>
                      </div>
                    </div>
                  </section>
                  <hr>
                  <!-- Video -->
                  <div class="column">
                    <section class="video-section">
                      <h2 id="video-title">Que esperas para ser como ellos!</h2>
                      <div class="video-natacion">
                        <iframe width="560" height="315" src="https://www.youtube.com/embed/ikg5HEDg0zc" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen ></iframe>
                      </div>
                    </section>
                    <!-- Mapa -->
                    <section class="mapa-section">
                      <h2 id="video-title">Ven a vernos pronto, te estaremos esperando</h2>
                      <div class="mapa">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d19259261.85384036!2d-46.03760623672876!3d-53.89648631545837!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xb09dff882a7809e1%3A0xb08d0a385dc8c7c7!2z5Y2X5qW15aSn6Zm4!5e0!3m2!1sja!2smx!4v1654798002741!5m2!1sja!2smx" width="560" height="315" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                      </div>
                    </section>
                  </div>
                  <!-- Footer1 -->
                  <section id="footer">
                    <div class="panel panel-default">
                      <div class="panel-heading">
                        <h3 class="panel-title">Sobre nosotros</h3>
                      </div>
                      <div class="panel-body" style="background-color: #2698eb; color: white;">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec urna purus, gravida et semper quis, eleifend vel 
                        lectus. Donec mollis nisl non nibh elementum rutrum. Morbi arcu sapien, ullamcorper vel lacus ac, commodo tempus nisl. 
                        Suspendisse a ante sit amet libero aliquam molestie at quis velit. Pellentesque vitae posuere nisl. Cras ut mollis orci. 
                        Donec hendrerit tellus at lacinia ornare. Aliquam vulputate felis vel magna posuere interdum. Quisque varius ultrices libero 
                        id ornare. Donec aliquam massa interdum, tincidunt dolor non, luctus erat. Vivamus bibendum mauris eu condimentum porttitor. 
                        Phasellus sed tempor elit. Suspendisse finibus ex eget sapien pharetra, ac tempus sem mattis.
                      </div>
                    </div>
                  </section>
                </div>
              </div>
            </div>
          </div>
        </div> <!-- container -->
      </div> <!-- content -->
      <footer class="footer">
            <?= date('Y')?> &copy;
      </footer>
    </div>
  </body>
</html>
