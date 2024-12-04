<?php
include('Includes/search_delete_user.php'); // Inclui o arquivo PHP para usar suas funções
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buscar y Eliminar Usuarios</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="icon" href="img/logo.png" type="image/x-icon" />
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
        integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy"
        crossorigin="anonymous"></script>

    <?php include 'includes/navbar.php'; ?>
    <br><br>

    <div class="container">
        <h1>Panel de Administración</h1>

        <!-- Posts Section -->
        <div class="header-container">
            <h2 class="PR">Buscar Usuarios <span class="">🔎</span></h2>
        </div>

        <!-- Formulário de pesquisa -->
        <form method="POST" class="post">
            <div class="mb-3">
                <label for="search" class="form-label">Nombre del Usuario:</label>
                <input type="text" class="form-control" id="search" name="search" placeholder="Buscar por nombre del usuario..." value="<?php echo isset($_POST['search']) ? htmlspecialchars($_POST['search']) : ''; ?>">
            </div>
            <button type="submit" class="btn btn-primary">Buscar</button>
        </form>

        <?php if (!empty($users)) { ?>
    <h3>Usuarios encontrados:</h3>
    <div class="post row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
        <?php foreach ($users as $user) { ?>
            <div class="col-md-4 d-flex">
                <div class="card w-100 h-100">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo htmlspecialchars($user['username']); ?></h5>
                        <p class="card-text text-muted"><?php echo htmlspecialchars($user['email']); ?></p>
                    </div>
                    <div class="card-footer text-center">
                        <form method="POST" action="Includes/search_delete_user.php">
                            <input type="hidden" name="delete_user_id" value="<?php echo $user['id']; ?>">
                            <button type="submit" class="btn btn-danger btn-sm">Borrar</button>
                        </form>
                    </div>
                </div>
            </div>
        <?php } ?>
            </div>

            <!-- Paginação -->
            <div class="pagination">
                <?php if ($page > 1): ?>
                    <!-- Setas de navegação para a página anterior -->
                    <a href="?page=1" class="page-link">&laquo;&laquo;</a>
                    <a href="?page=<?php echo $page - 1; ?>" class="page-link">&laquo;</a>
                <?php endif; ?>

                <?php
                $maxLinks = 3;
                $startPage = max(1, $page - floor($maxLinks / 2));
                $endPage = min($totalPages, $startPage + $maxLinks - 1); 

                for ($i = $startPage; $i <= $endPage; $i++):
                    if ($i == $page):
                        echo "<a href='?page=$i' class='page-link active'>$i</a>";
                    else:
                        echo "<a href='?page=$i' class='page-link'>$i</a>";
                    endif;
                endfor;
                ?>

                <?php if ($page < $totalPages): ?>
                    <!-- Setas de navegação para a próxima página -->
                    <a href="?page=<?php echo $page + 1; ?>" class="page-link">&raquo;</a>
                    <a href="?page=<?php echo $totalPages; ?>" class="page-link">&raquo;&raquo;</a>
                <?php endif; ?>
            </div>

        <?php } elseif (isset($_POST['search']) && empty($users)) { ?>
            <div class="alert alert-info">No se encontraron usuarios.</div>
        <?php } ?>
    </div>
    <?php include 'includes/footer.php'; ?>

</body>

</html>
