<?php
include('includes/post_functions.php'); // Inclui o arquivo PHP para usar suas funções


// Número de posts por página
$postsPerPage = 3;

// Calculando o total de posts
$queryTotalPosts = "SELECT COUNT(*) FROM posts WHERE tag_id = 4";
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
    WHERE p.tag_id = 4
    LIMIT $postsPerPage OFFSET $offset
";
$stmt = $pdo->prepare($query);
$stmt->execute();
$recentPosts = $stmt->fetchAll();


// Definindo os limites de exibição de páginas (mostrando no máximo 3 páginas por vez)
$maxLinks = 3;
$startPage = max(1, $page - floor($maxLinks / 2)); // página inicial do bloco de links
$endPage = min($totalPages, $startPage + $maxLinks - 1); // página final do bloco de links

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <title>Fórum</title>
    <link rel="icon" href="img/logo.png" type="image/x-icon" />
    <link rel="stylesheet" href="css/style.css">
</head>

<body style="overflow-x: hidden;">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
        integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy"
        crossorigin="anonymous"></script>

    <!-- Navbar -->
    <?php include 'includes/navbar.php'; ?>
    <br><br>


    <div class="container">

        <h1>Foro Aplicación</h1>

        <!--Formulario de Postagem-->
        <div class="post">
            <form action="submit_post.php" method="POST">
                <textarea name="content" placeholder="Escribe tu publicación..." required></textarea><br>
                <select name="tag_id" id="tags">
                    <option value="">Elige una etiqueta...</option>
                    <?php foreach ($tags as $tag): ?>
                        <option value="<?= $tag['id']; ?>"><?= $tag['name']; ?></option>
                    <?php endforeach; ?>
                </select><br><br>
                <button type="submit">Enviar Publicación</button>
            </form>
        </div>

        <div class="header-container">
            <h2 class="PR">Posts Aplicación 📱</h2>

        </div>

        <?php
        foreach ($recentPosts as $post): ?>
            <div class="post" id="post-<?= $post['id']; ?>"> <!-- ID único para cada post -->
                <div class="post-content">
                    <div class="post-header">
                        <h3><?= $post['username']; ?></h3>
                        <h6> - <?= $post['created_at']; ?></h6>
                    </div>
                    <p><?= $post['content']; ?></p>
                </div>


                <div class="like-button">
                    <?php
                    // Verifica se o usuário já curtiu o post
                    $stmtLikes = $pdo->prepare($queryLikes);
                    $stmtLikes->execute([$post['id']]);
                    $likesCount = $stmtLikes->fetchColumn();

                    $stmtUserLike = $pdo->prepare($queryUserLike);
                    $stmtUserLike->execute([$post['id'], $_SESSION['user_id']]);
                    $userHasLiked = $stmtUserLike->fetchColumn();

                    // Verifica se o usuário atual é o autor do post
                    $isPostOwner = $post['user_id'] == $_SESSION['user_id'];
                    ?>

                    <div class="like-section">
                        <?php if ($userHasLiked): ?>
                            <span span class="likes-gusta">Me gusta</span>
                        <?php elseif (!$isPostOwner): // Permite curtir apenas se não for o autor 
                        ?>
                            <form action="like_post.php" method="POST">
                                <input type="hidden" name="post_id" value="<?= $post['id']; ?>">
                                <button class="likes-post"> like </button>
                            </form>
                        <?php endif; ?>
                    </div>

                    <div class="likes-count-section">
                        <span class="likes-count"><?= $likesCount; ?> Likes</span>
                    </div>
                </div>


                <!-- Exibe botões de editar e excluir se for o criador do post -->
                <?php if ($post['user_id'] == $_SESSION['user_id']): ?>
                    <div class="actions">
                        <button class="button open-modal" data-id="<?= $post['id']; ?>" data-type="post">Editar</button> |
                        <button class="open-modal" data-id="<?= $post['id']; ?>" data-type="delete_post">Excluir</button>
                    </div>
                <?php endif; ?>

                <!-- Exibe as respostas abaixo do post -->
                <div class="responses">
                    <?php
                    // Recupera as respostas para este post
                    $stmtReplies = $pdo->prepare($queryReplies);
                    $stmtReplies->execute([$post['id']]);
                    $replies = $stmtReplies->fetchAll();

                    foreach ($replies as $reply): ?>
                        <div class="response">
                            <strong><?= $reply['reply_username']; ?> - <?= $reply['created_at']; ?></strong>
                            <p><?= $reply['content']; ?></p>

                            <!-- Exibe botões de editar e excluir se for o criador da resposta -->
                            <?php if ($reply['user_id'] == $_SESSION['user_id']): ?>
                                <div class="actions">
                                    <button class="open-modal" data-id="<?= $reply['id']; ?>" data-type="edit_reply">Editar</button>
                                    |
                                    <button class="open-modal" data-id="<?= $reply['id']; ?>"
                                        data-type="delete_reply">Excluir</button>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>

                <!-- Formulário para responder ao post -->
                <form action="submit_reply.php" method="POST">
                    <textarea name="content" placeholder="Responder a la publicación..." required></textarea><br>
                    <input type="hidden" name="post_id" value="<?= $post['id']; ?>">
                    <button type="submit">Responder</button>
                </form>
            </div>


        <?php endforeach; ?>



        <!-- Navegação de Páginas -->
        <div class="pagination">
            <?php if ($page > 1): ?>
                <!-- Setas de navegação para a página anterior -->
                <a href="?page=1" class="page-link">&laquo;&laquo;</a>
                <a href="?page=<?php echo $page - 1; ?>" class="page-link">&laquo;</a>
            <?php endif; ?>

            <?php
            // Exibe os links das páginas no intervalo determinado
            for ($i = $startPage; $i <= $endPage; $i++):
                if ($i == $page):
                    // A página atual recebe uma classe especial para destacá-la
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


        <div id="edit-modal" class="modal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <h2 id="edit-modal-title">Editar Post</h2>
                <form id="edit-modal-form" method="POST">
                    <textarea name="content" id="edit-modal-content" placeholder="Cambiar contenido..."
                        required></textarea><br>

                    <!-- Campo para escolher uma etiqueta -->
                    <select name="tag_id" id="tags" required>
                        <option value="">Elige una etiqueta...</option>
                        <?php foreach ($tags as $tag): ?>
                            <option value="<?= $tag['id']; ?>" <?= (isset($post['tag_id']) && $post['tag_id'] == $tag['id']) ? 'selected' : ''; ?>>
                                <?= $tag['name']; ?>
                            </option>
                        <?php endforeach; ?>
                    </select><br><br>

                    <button type="submit" id="edit-modal-action">Guardar cambios</button>
                </form>
            </div>
        </div>


        <!-- Modal de Exclusão -->
        <div id="delete-modal" class="modal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <h2 id="delete-modal-title">Borrar Post/Resposta</h2>
                <p>¿Estás seguro de que deseas eliminar?  Esta acción no se puede deshacer.</p>
                <form id="delete-modal-form" method="POST">
                    <button type="submit" id="delete-modal-action">Excluir</button>
                </form>
            </div>
        </div>
    </div>

    <?php include 'js/script.php'; ?>

    <?php include 'includes/footer.php'; ?>
</body>

</html>