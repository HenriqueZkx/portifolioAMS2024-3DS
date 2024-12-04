<?php
include('db.php');

include('includes/post_functions.php'); // Inclui o arquivo PHP para usar suas funções

// Inicialize a variável de resultados
$searchResults = [];

// Verifique se há um parâmetro 'post_id' na URL
if (isset($_GET['post_id']) && is_numeric($_GET['post_id'])) {
    $postId = intval($_GET['post_id']);

    // Consulta para buscar o post pelo ID
    $queryPostById = "
        SELECT p.id, p.user_id, p.content, p.created_at, u.username
        FROM posts p
        JOIN users u ON p.user_id = u.id
        WHERE p.id = :post_id";
    
    $stmt = $pdo->prepare($queryPostById);
    $stmt->execute(['post_id' => $postId]);
    $searchResults = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Verifique se há um parâmetro 'query' para busca por termo
} elseif (isset($_GET['query']) && !empty(trim($_GET['query']))) {
    $searchQuery = trim($_GET['query']);

    // Consulta para buscar posts que correspondem ao termo
    $querySearchPosts = "
        SELECT p.id, p.user_id, p.content, p.created_at, u.username
        FROM posts p
        JOIN users u ON p.user_id = u.id
        WHERE p.content LIKE :search
        ORDER BY p.created_at DESC";

    $stmt = $pdo->prepare($querySearchPosts);
    $stmt->execute(['search' => '%' . $searchQuery . '%']);
    $searchResults = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Foro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="icon" href="img/logo.png" type="image/x-icon" />
    <link rel="stylesheet" href="css/style.css">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script> <!-- Ícones -->

    
</head>

<body>
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
        
    <?php
        // Verifica se foi clicado um post específico
        $isPostClicked = isset($_GET['post_id']);
        $searchQuery = isset($_GET['query']) ? $_GET['query'] : ''; // Termo de busca
        
        // Se um post foi clicado, exibe apenas "Resultados da Busca"
        if ($isPostClicked): ?>
            <h1 class="PR">Resultados de la búsqueda</h1>
        <?php else: ?>
            <h1 class="PR">Resultados de la búsqueda: "<?= htmlspecialchars($searchQuery); ?>"</h1>
        <?php endif; ?>    

        <?php if ($searchResults): ?>
            <?php foreach ($searchResults as $post): ?>
                <div class="post" id="post-<?= $post['id']; ?>"> <!-- Post container -->
                    <div class="post-content">
                        <!-- Cabeçalho do Post -->
                        <div class="post-header">
                            <h3><?= htmlspecialchars($post['username']); ?></h3>
                            <h6> - <?= htmlspecialchars($post['created_at']); ?></h6>
                        </div>
                        <!-- Conteúdo do Post -->
                        <p><?= htmlspecialchars($post['content']); ?></p>
                    </div>

                    <!-- Exibindo as tags associadas ao post -->
                    <?php
                    $tagsForPost = [];
                    $queryPostTags = "
                        SELECT name 
                        FROM tags 
                        WHERE id IN (SELECT tag_id FROM post_tags WHERE post_id = ?)";
                    $stmtTagsPost = $pdo->prepare($queryPostTags);
                    $stmtTagsPost->execute([$post['id']]);
                    $tagsForPost = $stmtTagsPost->fetchAll(PDO::FETCH_ASSOC);

                    if ($tagsForPost): ?>
                        <div class="tags">
                            <?php foreach ($tagsForPost as $tag): ?>
                                <div class="tag-box"><?= htmlspecialchars($tag['name']); ?></div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>

                    <!-- Like Button -->
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
                            <?php elseif (!$isPostOwner): 
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

                    <!-- Botões de Editar/Excluir -->
                    <?php if ($post['user_id'] == $_SESSION['user_id']): ?>
                        <div class="actions">
                            <button class="button open-modal" data-id="<?= $post['id']; ?>" data-type="post">Editar</button> |
                            <button class="open-modal" data-id="<?= $post['id']; ?>" data-type="delete_post">Excluir</button>
                        </div>
                    <?php endif; ?>

                    <!-- Respostas -->
                    <div class="responses">
                        <?php
                        $queryReplies = "
                            SELECT r.id, r.user_id, r.content, r.created_at, u.username AS reply_username
                            FROM replies r
                            JOIN users u ON r.user_id = u.id
                            WHERE r.post_id = ?";
                        $stmtReplies = $pdo->prepare($queryReplies);
                        $stmtReplies->execute([$post['id']]);
                        $replies = $stmtReplies->fetchAll(PDO::FETCH_ASSOC);

                        foreach ($replies as $reply): ?>
                            <div class="response">
                                <h6><?= htmlspecialchars($reply['reply_username']); ?>
                                    / <?= htmlspecialchars($reply['created_at']); ?></h6>
                                <p><?= htmlspecialchars($reply['content']); ?></p>

                                <!-- Editar/Excluir Respostas -->
                                <?php if ($reply['user_id'] == $_SESSION['user_id']): ?>
                                    <div class="actions">
                                        <button class="open-modal" data-id="<?= $reply['id']; ?>" data-type="edit_reply">Editar</button>
                                        |
                                        <button class="open-modal" data-id="<?= $reply['id']; ?>" data-type="delete_reply">Excluir</button>
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <!-- Formulário para Responder -->
                    <form action="submit_reply.php" method="POST">
                        <textarea name="content" placeholder="Responda ao post..." required></textarea><br>
                        <input type="hidden" name="post_id" value="<?= $post['id']; ?>">
                        <button type="submit">Resposta</button>
                    </form>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="post-content">No se han encontrado resultados para "<?= htmlspecialchars($searchQuery); ?>"</div>
        <?php endif; ?>

        <div id="edit-modal" class="modal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <h2 id="edit-modal-title">Editar Post</h2>
                <form id="edit-modal-form" method="POST">
                    <textarea name="content" id="edit-modal-content" placeholder="Cambiar contenido..."
                        required></textarea><br>

                    <!-- Campo para escolher uma etiqueta -->
                    <select name="tag_id" id="tags">
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
                    <button type="submit" id="delete-modal-action">Borrar</button>
                </form>
            </div>
        </div>
    </div>



    <?php include 'includes/footer.php'; ?>
    <?php include 'js/script.php'; ?>

</body>

</html>