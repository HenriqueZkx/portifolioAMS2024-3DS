
<div class="page">
  <header class="section page-header">
    <!-- RD Navbar: Deixa o que é estatico na tela ou não-->
    <div class="rd-navbar-wrap">
      <nav
        class="rd-navbar rd-navbar-corporate"
        data-layout="rd-navbar-fixed"
        data-sm-layout="rd-navbar-fixed"
        data-md-layout="rd-navbar-fixed"
        data-md-device-layout="rd-navbar-fixed"
        data-lg-layout="rd-navbar-static"
        data-lg-device-layout="rd-navbar-fixed"
        data-xl-layout="rd-navbar-static"
        data-xl-device-layout="rd-navbar-static"
        data-xxl-layout="rd-navbar-static"
        data-xxl-device-layout="rd-navbar-static"
        data-lg-stick-up-offset="46px"
        data-xl-stick-up-offset="46px"
        data-xxl-stick-up-offset="106px"
        data-lg-stick-up="true"
        data-xl-stick-up="true"
        data-xxl-stick-up="true"
      >
        <div
          class="rd-navbar-collapse-toggle rd-navbar-fixed-element-1"
          data-rd-navbar-toggle=".rd-navbar-collapse"
        >
          <span></span>
        </div>
        <div class="rd-navbar-aside-outer">
          <div class="rd-navbar-aside">
            <!-- RD Navbar Panel-->
            <div class="rd-navbar-panel">
              <!-- RD Navbar Toggle-->
              <button
                class="rd-navbar-toggle"
                data-rd-navbar-toggle=".rd-navbar-nav-wrap"
              >
                <span></span>
              </button>
              <!-- RD Navbar Brand: a parte branca em cima da navbar-->
              <div class="rd-navbar-brand">
                <!--Brand: as informações dentro da Brand,e definindo que ela não é estatica na tela-->
                <a class="brand" href="#">
                  <img src="images/logo.png" class="logo"/></a>
              </div>
            </div>
            <div class="rd-navbar-aside-right rd-navbar-collapse">
              <ul class="rd-navbar-corporate-contacts">
                <li>
                  <div class="unit unit-spacing-xs">
                    <div class="unit-left">
                      <span class=""></span>
                    </div>
                    <div class="unit-body">
                      <p>Nuevos Caminos</p>
                    </div>
                  </div>
                </li>
                <li>
                  <div class="unit unit-spacing-xs">
                    <div class="unit-left">
                      <span class=""></span>
                    </div>
                    <div class="unit-body">
                      <a>Tu viaje comienza aquí</a>
                    </div>
                  </div>
                </li>
              </ul>
              <!--Botão da Brand--->
              <a
                class="button button-md button-default-outline-2 button-ujarak"
                href="forum/">Foro</a>
            </div>
          </div>
        </div>
        <!-- Icones das redes sociais -->
        <div class="rd-navbar-main-outer">
          <div class="rd-navbar-main">
            <div class="rd-navbar-nav-wrap">
              <ul class="list-inline list-inline-md rd-navbar-corporate-list-social">
                <li><a class="icon fa fa-twitter" href="https://x.com/Nuevos_Caminos0"></a></li>
                <li><a class="icon fa fa-instagram" href="https://www.instagram.com/tcc_nuevoscaminos/"></a></li>
              </ul>
              <!-- RD Navbar Nav: Começo da navbar-->
              <ul class="rd-navbar-nav">
                <li class="rd-nav-item">
                  <a class="rd-nav-link" href="../index.php">Home</a>
                </li>
                <li class="rd-nav-item">
                  <a class="rd-nav-link" href="#">Sobre nosotros</a>
                </li>
                <li class="rd-nav-item dropdown">
                  <a class="rd-nav-link" href="#" id="navbarDropdown1" role="button" data-toggle="dropdown" aria-expanded="false">Información</a>
                  <div class="dropdown-menu" aria-labelledby="navbarDropdown1">
                    <a class="dropdown-item" href="src/hogar.php">Hogar</a>
                    <a class="dropdown-item" href="src/empreabilidad.php">Empreabilidad</a>
                    <a class="dropdown-item" href="src/consejos.php">Consejos diarios</a>
                  </div>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </nav>
    </div>
  </header>


<!-- Script para adicionar a classe active -->
<script>
  document.addEventListener("DOMContentLoaded", function() {
    // Obtém a URL atual da página sem parâmetros
    var currentPage = window.location.pathname.split("/").pop();

    // Seleciona todos os itens de navegação
    var navItems = document.querySelectorAll('.rd-navbar-nav .rd-nav-item');

    // Loop pelos itens de navegação
    navItems.forEach(function(item) {
      // Seleciona o link dentro do item
      var link = item.querySelector('a');

      // Verifica se o link existe e compara o nome do arquivo com a página atual
      if (link && link.getAttribute('href').split("/").pop() === currentPage) {
        // Remove a classe 'active' de todos os itens de navegação
        navItems.forEach(function(nav) {
          nav.classList.remove('active');
        });
        // Adiciona a classe 'active' ao item atual
        item.classList.add('active');
      }
    });
  });
</script>
