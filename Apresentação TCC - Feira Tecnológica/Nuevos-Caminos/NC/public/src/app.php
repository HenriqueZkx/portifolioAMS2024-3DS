<!DOCTYPE html>
<html class="wide wow-animation" lang="es">
  <head>
    <title>App</title>
    <meta name="format-detection" content="telephone=no" />
    <meta
      name="viewport"
      content="width=device-width, height=device-height, initial-scale=1.0, maximum-scale=1.0, user-scalable=0"
    />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta charset="utf-8" />
    <link rel="icon" href="../images/logo.png" type="image/x-icon" />
    <!-- Stylesheets-->
    <link
      rel="stylesheet"
      type="text/css"
      href="//fonts.googleapis.com/css?family=Montserrat:400,500,600,700%7CPoppins:400%7CTeko:300,400"
    />
    <link rel="stylesheet" href="../css/bootstrap.css" />
    <link rel="stylesheet" href="../css/fonts.css" />
    <link rel="stylesheet" href="../css/style.css" />
    <style>
      .ie-panel {
        display: none;
        background: #212121;
        padding: 10px 0;
        box-shadow: 3px 3px 5px 0 rgba(0, 0, 0, 0.3);
        clear: both;
        text-align: center;
        position: relative;
        z-index: 1;
      }
      html.ie-10 .ie-panel,
      html.lt-ie-10 .ie-panel {
        display: block;
      }
    </style>
  </head>
  <body>
  <?php include 'includes/NavbarInf.php'; ?>
  <section class="breadcrumbs-custom-inset p-0">
        <div class="breadcrumbs-custom context-dark bg-overlay-60">
          <div class="container">
            <h2 class="breadcrumbs-custom-title">Aplicación móvil</h2>
            <ul class="breadcrumbs-custom-path">
              <li><a href="../index.php">Home</a></li>
              <li class="active">App</li>
            </ul>
          </div>
          <!-- foto Arrumada-->
          <div
            class="box-position"
            style="background-image: url(../images/apps.jpg)" 
          ></div>
        </div>
      </section>
      <!-- Base typography-->
      <section class="section section-sm section-first bg-default custom-text-left">
        <div class="container">
         
            <div class="col-xl-17">
              <ul class="list-xl box-typography">
                <li>
                  <h3 style="height: 60px;">O que é nossa aplicação mobile?</h3>
                  <p>
                    Nossa aplicação basea-se em auxiliar o imigrante que planeja vir ao território brasileiro, ou que já está presente dentro do território.

                  <br><br>Contendo as mesmas informações, porém com um foque a mais ao processo de adaptação, os auxiliando em seu estagio inicial de adaptação.

                  <br><br>Totalmente offline para ser usado desde o inicio de sua chegada até o momento em que recuperar seu sinal, para se conectar novamente ao web site onde tem mais informações e duvidas respondidas.
                  </p>
                </li>
                <li>
                  <h3 style="height: 60px;">Informações</h3>
                  <p>
                    A aplicação móvel contém informações sobre o inicio de sua nova caminhada como moradia, empregabilidade, locomoção dentro do teritório entre outras.
                    Além de conter informações sobre a documentação nescesaria do imigrante como CRNM.

                    <br><br> 
                    <a id="imagem" href="imagesempre/curriculo.pdf" download>Descargar App</a><br><br>
                    Lembrando-se a aplicação pode sofrer <strong id="5">alterações contantes</strong> para se adaptar a novas informações ou dicas.
                  </p>
                </li>
              </ul>
            </div>
          
        </div>
    </div>
    <section
        class="section section-sm section-top-0 section-fluid section-relative bg-gray-4"
      >
    <div class="container-fluid">
<br>
          <!-- Carrossel das fotos-->
          <div
            class="owl-carousel owl-classic owl-dots-secondary"
            data-items="1"
            data-sm-items="2"
            data-md-items="3"

            data-stage-padding="15"
            data-xxl-stage-padding="0"
            data-margin="30"
            data-autoplay="false"
            data-nav="true"
            data-dots="true"
          >

            <article class="thumbnail thumbnail-mary">
              <div class="thumbnail-mary-figure">
                <img
                  src="../images/App.png"
                  alt=""
                  width="270"
                  height="270"
                />
              </div>
              <div class="thumbnail-mary-caption">
                <a
                  class="icon fl-bigmug-line-zoom60"
                  href="../images/App.png"
                  data-lightgallery="item"
                  ><img
                    src="../images/App.png"
                    alt=""
                    width="270"
                    height="270"
                /></a>
              </div>
            </article>

            <article class="thumbnail thumbnail-mary">
              <div class="thumbnail-mary-figure">
                <img
                  src="../images/App.png"
                  alt=""
                  width="270"
                  height="195"
                />
              </div>
              <div class="thumbnail-mary-caption">
                <a
                  class="icon fl-bigmug-line-zoom60"
                  href="../images/App.png"
                  data-lightgallery="item"
                  ><img
                    src="../images/App.png"
                    alt=""
                    width="270"
                    height="195"
                /></a>
              </div>
            </article>

            <article class="thumbnail thumbnail-mary">
              <div class="thumbnail-mary-figure">
                <img
                  src="../images/App.png"
                  alt=""
                  width="270"
                  height="195"
                />
              </div>
              <div class="thumbnail-mary-caption">
                <a
                  class="icon fl-bigmug-line-zoom60"
                  href="../images/App.png"
                  data-lightgallery="item"
                  ><img
                    src="../images/App.png"
                    alt=""
                    width="270"
                    height="195"
                /></a>
              </div>
            </article>
            </div>
            </div>
           </section>

           <?php include 'includes/footerInf.php'; ?>
    
    <!-- Global Mailform Output-->
    <div class="snackbars" id="form-output-global"></div>
    <!-- Javascript-->
    <script src="../js/core.min.js"></script>
    <script src="../js/script.js"></script>
    <script src="../js/empleabilidade.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.4/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.4/ScrollToPlugin.min.js"></script>

  </body>
</html>
