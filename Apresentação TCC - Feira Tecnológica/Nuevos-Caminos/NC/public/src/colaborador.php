<!DOCTYPE html>
<html class="wide wow-animation" lang="es">

<head>
    <title>Colaborador</title>
    <meta name="format-detection" content="telephone=no" />
    <meta
        name="viewport"
        content="width=device-width, height=device-height, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta charset="utf-8" />
    <link rel="icon" href="../images/logo.png" type="image/x-icon" />
    <!-- Stylesheets-->
    <link
        rel="stylesheet"
        type="text/css"
        href="//fonts.googleapis.com/css?family=Montserrat:400,500,600,700%7CPoppins:400%7CTeko:300,400" />
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
                <h2 class="breadcrumbs-custom-title">Colaborador</h2>
            </div>

            <div
                class="box-position"
                style="background-image: url(../images/noticias/colab.jpg)"></div>
        </div>
    </section>
    <!-- Base typography-->
    <section class="section section-sm section-first bg-default custom-text-left">
        <div class="container">

            <div class="col-xl-17">
                <ul class="list-xl box-typography">
                    <li>
                        <h3 style="height: 60px;">Conviértete en colaborador de Nuevos Caminos</h3>
                        <h6 style="color: #505050;">
                            <img src="../images/colaboradorpag.jpeg" height="300" width="300"><br><br>

                            <strong>Nuevos Caminos</strong> se creó para facilitar la vida de los inmigrantes recién llegados a Brasil, ofreciendo información fiable, consejos prácticos y apoyo para su integración. Pero para continuar con nuestra misión, <strong>¡te necesitamos!</strong>
                            <br><br>
                            Ser colaborador de Nuevos Caminos significa contribuir a un proyecto que transforma vidas, ayudando a miles de personas a sentirse acogidas e informadas.
                        </h6>
                    </li>
                    <li>
                        <h3 style="height: 60px;">¿Cómo funciona la colaboración en nuestro proyecto?</h3>
                        <h6 style="color: #505050;">
                            <img src="../images/comoajudar.jpeg" height="300" width="300" style="display: block; margin: 0 auto;"><br><br>
                            <strong>Revisar:</strong> En nuestro proyecto, buscamos colaboradores que estén interesados en ayudarnos a crecer y mejorar continuamente. Al unirse, tendrás acceso al código fuente en nuestro repositorio de <strong>GitHub</strong>, donde podrás contribuir realizando cambios directamente en el sitio web.<br><br>
                            <strong>Compartir:</strong> Utilizando Git y <strong>Bash</strong>, puedes clonar el repositorio, hacer las modificaciones necesarias y luego actualizar el sitio a través de comandos sencillos. A través de este flujo de trabajo, cada colaborador tiene la posibilidad de realizar mejoras, correcciones y agregar nuevas características, siempre con un enfoque colaborativo y abierto. <br><strong>¡Contamos contigo!</strong>
                        </h6>
                    </li>
                    <li>
                        <h3 id="normas">Normas</h3>
                        <h6 style="color: #505050;">
                            <img src="../images/regras.png" height="300" width="300" style="display: block; margin: 0 auto;"><br><br>
                            <strong>Respeto:</strong> Todas las contribuciones deben promover un entorno acogedor y respetuoso para todas las personas, independientemente de su origen.<br><br>
                            <strong>Compromiso:</strong> Contribuir de forma coherente y transparente para garantizar que el sitio siga siendo útil y esté actualizado.
                        </h6>
                    </li>
                    <li id="espaco">
                        <h6 style="color: #505050;">
                        <a href="mailto:nuevoscaminos02@gmail.com?subject=Solicitud%20de%20colaboración&body=Estimado%20equipo,%0D%0A%0D%0AEstoy%20interesado%20en%20convertirme%20en%20colaborador%20de%20su%20proyecto.%20Por%20favor,%20comuníquense%20con%20migo%20para%20más%20detalles.%0D%0A%0D%0AAtentamente,%0D%0A[Su%20Nombre]" class="button button-md button-default-outline-2 button-ujarak">
    Enviar solicitud
</a><br><br>                            <strong>¡Nos encantaría contar con tu ayuda!</strong> Haz clic en el botón de arriba para inscribirte y unirte a nuestro equipo.
                        </h6>
                </ul>
            </div>
        </div>
        </div>

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