<!-- Navbar -->
<nav class="navbar navbar-dark bg-dark fixed-top tam-nav">
    <div class="container-fluid">
        <a class="navbar-brand" href="#"><img src="img/logo.png" class="logo" width="50px" height="50px"> NC - Foro</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas"
            data-bs-target="#offcanvasDarkNavbar" aria-controls="offcanvasDarkNavbar"
            aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="offcanvas offcanvas-end text-bg-dark" tabindex="-1" id="offcanvasDarkNavbar"
            aria-labelledby="offcanvasDarkNavbarLabel">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title" id="offcanvasDarkNavbarLabel">Nuevos - Foro</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"
                    aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="./index.php">Home</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            Etiquetas
                        </a>
                        <ul class="dropdown-menu dropdown-menu-dark">
                            <li><a class="dropdown-item" href="empreabilidadF.php">Empleabilidad</a></li>
                            <li><a class="dropdown-item" href="hogarF.php">Hogar</a></li>
                            <li><a class="dropdown-item" href="consejosF.php">Consejos</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            Feedbacks
                        </a>
                        <ul class="dropdown-menu dropdown-menu-dark">
                            <li><a class="dropdown-item" href="FeedbackApp.php">App</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="FeedbackWeb.php">Sitio Web</a></li>
                        </ul>
                    </li>
                    <?php
                    if (isset($_SESSION['username']) && $_SESSION['username'] == 'admin') {
                        echo '<li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                Admin
                            </a>
                            <ul class="dropdown-menu dropdown-menu-dark">
                                <li><a class="dropdown-item" href="admin.php">Posts</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item" href="adminUser.php">Usuarios</a></li>
                            </ul>
                        </li>';
                    }
                    ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            Su cuenta
                        </a>
                        <ul class="dropdown-menu dropdown-menu-dark">
                            <li>
                                <?php
                                // Verifica se o usuário não é o admin
                                if (isset($_SESSION['username']) && $_SESSION['username'] != 'admin') {
                                    // Exibe o botão "Modificar" apenas para usuários que não são admin
                                    echo '<button class="dropdown-item" type="button" id="openOffcanvasBtn" data-bs-toggle="offcanvas" data-bs-target="#userOffcanvas">
                                <h6>Modificar</h6>
                                </button>';
                                }
                                ?>
                            </li>

                            <li><a class="dropdown-item" href="PostUser.php">Tus posts</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="logout.php">Salir</a></li>
                            </ul>
                    </li>
                </ul>
                <form class="d-flex mt-3" action="search_results.php" method="GET">
                    <input class="form-control me-2" id="search-input" name="query" type="search" placeholder="Escribe aquí..." aria-label="Search">
                    <button class="btn btn-success" type="submit">Buscar</button>
                </form>
                <div id="search-results"></div> <!-- Aqui serão exibidos os cards -->
            </div>
        </div>
    </div>
</nav>

<!-- Offcanvas -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="userOffcanvas" aria-labelledby="userOffcanvasLabel">
    <div class="offcanvas-header">
        <h5 id="userOffcanvasLabel">Informações do Usuário</h5>
        <!-- Botão de fechar visível apenas em dispositivos móveis -->
        <button type="button" class="btn-close text-reset d-block d-md-none" data-bs-dismiss="offcanvas"
            aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <form action="update_user.php" method="POST">
            <label class="NewUser" for="username">Nuevo Nombre:</label>
            <input class="NewUser_text" type="text" id="username" name="username"
                value="<?php echo $_SESSION['username']; ?>" required>

            <label class="NewUser" for="password">Nueva Contraseña:</label>
            <input class="NewUser_text" type="password" id="password" name="password" placeholder="Opcional">

            <label class="NewUser" for="confirm-password">Confirmar Nueva Contraseña:</label>
            <input class="NewUser_text" type="password" id="confirm-password" name="confirm-password" placeholder="Ingrese la misma que la de arriba....">

            <button type="submit">Guardar Cambios.</button>
        </form>
    </div>
</div>

<script src="js/script.php"></script>