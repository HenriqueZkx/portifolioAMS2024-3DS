<?php
include('includes/post_functions.php'); // Inclui o arquivo PHP para usar suas funções

// Número de posts por página
$postsPerPage = 5;

// Calculando o total de posts
$queryTotalPosts = "SELECT COUNT(*) FROM posts WHERE tag_id = 3";
$stmtTotalPosts = $pdo->prepare($queryTotalPosts);
$stmtTotalPosts->execute();
$totalPosts = $stmtTotalPosts->fetchColumn();

// Calculando o número total de páginas
$totalPages = ceil($totalPosts / $postsPerPage);

// Página atual
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

// Verificando a página mínima e máxima
if ($page < 1) $page = 1;
if ($page > $totalPages) $page = $totalPages;

// Calculando o limite de posts para a consulta
$offset = ($page - 1) * $postsPerPage;

$query = "
    SELECT p.id, p.user_id, p.created_at, p.content, u.username 
    FROM posts p 
    JOIN users u ON p.user_id = u.id 
    WHERE p.tag_id = 3
    LIMIT $postsPerPage OFFSET $offset
";
$stmt = $pdo->prepare($query);
$stmt->execute();
$recentPosts = $stmt->fetchAll();

?>

<!-- politica_privacidade.php -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Política de Privacidad</title>
    <!-- Adicionando o Bootstrap para a página -->
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

        <br><br>

    <!-- Navbar -->
    <?php include 'includes/navbar.php'; ?>

    <div class="container">
        <h1 class="text-center">Política de Privacidad</h1>

        <h5>Esta Política de Privacidad describe cómo recopilamos, usamos, protegemos y compartimos su información personal en nuestro foro. Nuestro objetivo es garantizar que su experiencia como usuario sea segura y agradable, respetando su privacidad.</h5>

        <h2 class="PR">1. Recopilación de Información</h2>
        <h5>Recopilamos información personal, como nombre, correo electrónico y otros datos proporcionados durante el registro o al interactuar con nuestro contenido. Esta información se utiliza exclusivamente con el fin de proporcionar acceso al foro y mejorar nuestra plataforma.</h5>

        <h2 class="PR">2. Uso de la Información</h2>
        <h5>La información recopilada se utiliza para mejorar su experiencia, proporcionar contenido relevante sobre empleabilidad, vivienda y consejos diarios, así como responder preguntas y dudas relacionadas con el proceso de integración en Brasil.</h5>

        <h2 class="PR">3. Protección de Datos</h2>
        <h5>Implementamos medidas de seguridad para proteger su información personal contra accesos no autorizados. Sin embargo, ninguna forma de transmisión o almacenamiento de datos es 100% segura, y no podemos garantizar la protección total de los datos.</h5>

        <h2 class="PR">4. Compartición de Información</h2>
        <h5>No compartimos su información personal con terceros, excepto cuando sea necesario para cumplir con las leyes brasileñas o si lo autoriza explícitamente.</h5>

        <h2 class="PR">5. Cambios en esta Política</h2>
        <h5>Podemos actualizar esta Política de Privacidad periódicamente para reflejar cambios en nuestras prácticas o por razones legales. Cualquier cambio será publicado en este espacio.</h5>

        <h2 class="PR">6. Consentimiento</h2>
        <h5>Al utilizar el foro, usted acepta los términos descritos en esta Política de Privacidad.</h5>

    </div>

    <!-- Scripts do Bootstrap -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <?php include 'includes/footer.php'; ?>

</body>
</html>
