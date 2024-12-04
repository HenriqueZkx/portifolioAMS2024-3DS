<!DOCTYPE html>
<html class="wide wow-animation" lang="en">
  <head>
    <title>Nuevos Caminos - Sobre Nosotros</title>
    <meta name="format-detection" content="telephone=no" />
    <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0, maximum-scale=1.0, user-scalable=0"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta charset="utf-8"/>
    <link rel="icon" href="images/logo.png" type="image/x-icon" />
    <!-- Stylesheets-->
    <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Montserrat:400,500,600,700%7CPoppins:400%7CTeko:300,400"/>
    <link rel="stylesheet" href="css/bootstrap.css" />
    <link rel="stylesheet" href="css/fonts.css" />
    <link rel="stylesheet" href="css/style.css" />
    <link rel="stylesheet" href="css/styleF.css" />
  </head>
  <body>
    <?php include 'src/includes/Navbar.php'; ?>
      <!-- Breadcrumbs -->
      <section class="breadcrumbs-custom-inset p-0">
        <div class="breadcrumbs-custom context-dark bg-overlay-60">
          <div class="container">
            <h2 class="breadcrumbs-custom-title">Sobre Nosotros</h2>
            <ul class="breadcrumbs-custom-path">
              <li><a href="index.html">Home</a></li>
              <li class="active">Sobre Nosotros</li>
            </ul>
          </div>
          <!-- foto Arrumada-->
          <div
            class="box-position"
            style="background-image: url(images/sobre.jpg)" 
          ></div>
        </div>
      </section>
      <!-- Why choose us-->
      <section class="section section-sm section-first bg-default text-md-left">
        <div class="container">
          <div class="row row-50 justify-content-center align-items-xl-center">
            <div class="col-md-10 col-lg-5 col-xl-6">
              <img
                class = 'foto'
                src="images/imigrates.png" 
                alt=""
                width="519"
                height="564"
              /> <!-- Colocar foto do grupo depois--> 
            </div>
            <div class="col-md-10 col-lg-7 col-xl-6">
              <h1 class="text-spacing-25 font-weight-normal title-opacity-9">
                Por qué elegimos
              </h1>
              <!-- Bootstrap tabs-->
              <div class="tabs-custom tabs-horizontal tabs-line" id="tabs-4">
                <!-- Nav tabs-->
                <ul class="nav nav-tabs">
                  <li class="nav-item" role="presentation">
                    <a class="nav-link active" href="#tabs-4-1" data-toggle="tab" 
                    >Experiencia</a>
                  </li>
                  <li class="nav-item" role="presentation">
                    <a class="nav-link" href="#tabs-4-2" data-toggle="tab"
                      >misión</a>
                  </li>
                </ul>
                <!-- Pq nos ecolher arrumado-->
                <!-- Tab panes-->
                <div class="tab-content">
                  <div class="tab-pane fade show active" id="tabs-4-1">
                    <p>
                      Nuevos Caminos se especializa en apoyar a los inmigrantes españoles en Brasil, ofreciendo asistencia para encontrar vivienda asequible, oportunidades laborales y acceso a servicios esenciales. Con años de experiencia, nuestro equipo se dedica a hacer su transición lo más suave y exitosa posible. Confíe en nosotros para comenzar su nueva vida con seguridad y oportunidades.
                    </p>
                  </div>
                  <div class="tab-pane fade" id="tabs-4-2">
                    <p>
                      Nuestra misión en Nuevos Caminos es minimizar los desafíos que enfrentan los inmigrantes españoles en Brasil, asegurando que tengan acceso a empleos y viviendas asequibles. Nos comprometemos a ofrecer un apoyo integral para que cada inmigrante pueda establecerse de manera segura y exitosa, con dignidad y oportunidades reales de crecimiento.
                    </p>
                    <div class="text-center text-sm-left offset-top-30 tab-height">
                      <ul class="row-16 list-0 list-custom list-marked list-marked-sm list-marked-secondary">
                        <li>Conocimiento del Territorio Brasileño</li>
                        <li>Entrada en el Mercado Laboral</li>
                        <li>Adaptación a Brasil</li>
                        <li>Mejores Condiciones en Viviendas</li>
                        <li>Sensación de Pertenencia</li>
                        <li>Apoyo Personalizado y Continuo</li>
                      </ul>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
      <!-- Pq nos ecolher arrumado-->
      <section class="section section-sm section-last bg-default">
        <div class="container">
          <h3>Equipe</h3>

          <div
            class="owl-carousel owl-modern"
            data-items="1"
            data-stage-padding="15"
            data-margin="30"
            data-dots="true"
            data-animation-in="fadeIn"
            data-animation-out="fadeOut"
            data-autoplay="true"
          >
            <!-- Quote Baneza-->
            <article class="quote-Baneza">
              <div class="quote-Baneza-body">
                <a class="quote-Baneza-figure"
                  ><img
                    class="img-circles"
                    src="images/int/B.jpg"
                    alt=""
                    width="100"
                    height="100"
                    style="margin: 10px;"
                /></a>
                <h5 class="quote-Baneza-cite">
                  <a href="#">Baneza Lívia</a>
                </h5>
                <p class="quote-Baneza-status">Parte escrita de la solicitud</p>
                <i class="bi bi-instagram"></i>
              </div>
            </article>
            <!-- Quote Diogo-->
            <article class="quote-Diogo">
              <div class="quote-Diogo-body">
                <a class="quote-Diogo-figure"
                  ><img
                    class="img-circles"
                    src="images/int/D.jpg"
                    alt=""
                    width="100"
                    height="100"
                    style="margin: 10px;"
                /></a>

                <h5 class="quote-Diogo-cite"><a href="#">Diogo Marques</a></h5>
                <p class="quote-Diogo-status">Desarrollador front-end y back-end de la aplicación</p>
              </div>
            </article>
            <!-- Quote Henrique-->
            <article class="quote-Henrique">
              <div class="quote-Henrique-body">
                <a class="quote-Diogo-figure" href="#"
                  ><img
                    class="img-circles"
                    src="images/int/H.jpg"
                    alt=""
                    width="100"
                    height="100"
                    style="margin: 10px;"
                /></a>
                <h5 class="quote-Henrique-cite"><a href="#">Henrique de Moraes</a></h5>
                <p class="quote-Henrique-status">Desarrollador front-end de aplicaciones</p>
              </div>
            </article>
            <!-- Quote Joao-->
            <article class="quote-Joao">
              <div class="quote-Joao-body">
                <a class="quote-Joao-figure"
                  ><img
                    class="img-circles"
                    src="images/int/joao.jpg"
                    alt=""
                    width="100"
                    height="100"
                    style="margin: 10px;"
                /></a>
                <h5 class="quote-Joao-cite"><a href="https://www.instagram.com/itsme_jo4n/">João Pedro</a></h5>
                <p class="quote-Joao-status">Parte escrita de la solicitud</p>
              </div>
            </article>
          </div>
        </div>
      </section>
      <!--Counters-->
      <!-- Tempo de Ativo-->
      <section class="section section-fluid bg-default">
        <div class="parallax-container" data-parallax-img="images/sobremeb.jpg">
            <div class="parallax-content section-xl context-dark bg-overlay-26">
                <div class="container">
                    <div class="row row-50 justify-content-center border-classic">
                        <div class="col-sm-6 col-md-5 col-lg-3">
                            <div class="counter-classic">
                                <div class="counter-classic-number" id="days">
                                    <span class="counter">0</span>
                                </div>
                                <h5 class="counter-classic-title">Días</h5>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-5 col-lg-3">
                            <div class="counter-classic">
                                <div class="counter-classic-number" id="hours">
                                    <span class="counter">0</span>
                                </div>
                                <h5 class="counter-classic-title">Horas</h5>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-5 col-lg-3">
                            <div class="counter-classic">
                                <div class="counter-classic-number" id="minutes">
                                    <span class="counter">0</span>
                                </div>
                                <h5 class="counter-classic-title">Minutos</h5>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-5 col-lg-3">
                            <div class="counter-classic">
                                <div class="counter-classic-number" id="seconds">
                                    <span class="counter">0</span>
                                </div>
                                <h5 class="counter-classic-title">Segundos</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<!-- Tempo de Ativo-->

<?php include 'src/includes/footer.php'; ?>

    </div>
    <!-- Global Mailform Output-->
    <div class="snackbars" id="form-output-global"></div>
    <!-- Javascript-->
    <script src="js/core.min.js"></script>
    <script src="js/script.js"></script>
    <script src="js/counter.js"></script>
  </body>
</html>
