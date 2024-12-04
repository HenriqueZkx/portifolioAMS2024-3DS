<?php
session_start();
include('db.php');


// Verificar se o usuário está logado
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// Alterar o conteúdo do post
if (isset($_POST['edit_post'])) {
    $postId = $_POST['post_id'];
    $content = $_POST['content'];

    $query = "UPDATE posts SET content = ? WHERE id = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$content, $postId]);

    header("Location: admin.php");
    exit;
}

// Excluir todas as respostas associadas ao post
if (isset($_POST['delete_post'])) {
    $postId = $_POST['post_id'];

    // Excluir as respostas associadas
    $queryReplies = "DELETE FROM replies WHERE post_id = ?";
    $stmtReplies = $pdo->prepare($queryReplies);
    $stmtReplies->execute([$postId]);

    // Agora, excluir o post
    $query = "DELETE FROM posts WHERE id = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$postId]);

    header("Location: admin.php");
    exit;
}

// Editar uma tag
if (isset($_POST['edit_tag'])) {
    $tagId = $_POST['tag_id'];
    $name = $_POST['tag_name'];

    $query = "UPDATE tags SET name = ? WHERE id = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$name, $tagId]);

    header("Location: admin.php");
    exit;
}

$query = "SELECT posts.*, users.username FROM posts
          JOIN users ON posts.user_id = users.id
          ORDER BY posts.created_at DESC";
$stmt = $pdo->prepare($query);
$stmt->execute();

$posts = $stmt->fetchAll();

if (!$posts) {
    $posts = [];  // Se não houver posts, inicialize com um array vazio
}

// Recupera as respostas para cada post
$queryReplies = "SELECT replies.*, users.username AS reply_username FROM replies
                 JOIN users ON replies.user_id = users.id
                 WHERE replies.post_id = ? ORDER BY replies.created_at DESC";

// Consulta para contar os likes de cada post
$queryTags = "SELECT * FROM tags";
$stmtTags = $pdo->prepare($queryTags);
$stmtTags->execute();
$tags = $stmtTags->fetchAll();

$queryPostTags = "SELECT tags.name FROM tags
                  JOIN post_tags ON tags.id = post_tags.tag_id
                  WHERE post_tags.post_id = ?";

// Recupera os posts com mais likes (top 3)
$queryTopPosts = "SELECT posts.*, users.username, COUNT(post_likes.post_id) AS likes_count 
                  FROM posts
                  JOIN users ON posts.user_id = users.id
                  LEFT JOIN post_likes ON posts.id = post_likes.post_id
                  GROUP BY posts.id
                  ORDER BY likes_count DESC
                  LIMIT 3";
$stmtTopPosts = $pdo->prepare($queryTopPosts);
$stmtTopPosts->execute();
$topPosts = $stmtTopPosts->fetchAll();


// Recupera os posts com o nome do criador (JOIN entre posts e users)
$query = "SELECT posts.*, users.username FROM posts
          JOIN users ON posts.user_id = users.id
          ORDER BY posts.created_at DESC";
$stmt = $pdo->prepare($query);
$stmt->execute();

// Verifique se a consulta retornou resultados antes de atribuir a variável
$posts = $stmt->fetchAll();

if (!$posts) {
    $posts = [];  // Se não houver posts, inicialize com um array vazio
}

// Recupera as respostas para cada post
$queryReplies = "SELECT replies.*, users.username AS reply_username FROM replies
                 JOIN users ON replies.user_id = users.id
                 WHERE replies.post_id = ? ORDER BY replies.created_at DESC";

// Consulta para contar os likes de cada post
$queryTags = "SELECT * FROM tags";
$stmtTags = $pdo->prepare($queryTags);
$stmtTags->execute();
$tags = $stmtTags->fetchAll();

$queryPostTags = "SELECT tags.name FROM tags
                  JOIN post_tags ON tags.id = post_tags.tag_id
                  WHERE post_tags.post_id = ?";

// Exibir o botão de like, verifique se o usuário já curtiu o post
$queryLikes = "SELECT COUNT(*) FROM post_likes WHERE post_id = ?";
$queryUserLike = "SELECT 1 FROM post_likes WHERE post_id = ? AND user_id = ?";

// Pega os posts mais recentes, excluindo os 3 com mais likes
$queryRecentPosts = "
    SELECT posts.*, users.username, COUNT(post_likes.post_id) AS likes_count
    FROM posts
    JOIN users ON posts.user_id = users.id
    LEFT JOIN post_likes ON posts.id = post_likes.post_id
    GROUP BY posts.id
    ORDER BY posts.created_at DESC
    LIMIT 5, 5";
$stmtRecentPosts = $pdo->prepare($queryRecentPosts);
$stmtRecentPosts->execute();
$recentPosts = $stmtRecentPosts->fetchAll();

// Definir o número de posts por página
$postsPerPage = 3;

// Verificar a página atual
$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
$offset = ($page - 1) * $postsPerPage;

// Recupera os posts com mais likes (top 3)
$queryTopPosts = "SELECT posts.*, users.username, COUNT(post_likes.post_id) AS likes_count 
                  FROM posts
                  JOIN users ON posts.user_id = users.id
                  LEFT JOIN post_likes ON posts.id = post_likes.post_id
                  GROUP BY posts.id
                  ORDER BY likes_count DESC
                  LIMIT 3";
$stmtTopPosts = $pdo->prepare($queryTopPosts);
$stmtTopPosts->execute();
$topPosts = $stmtTopPosts->fetchAll();

// Recupera os posts mais recentes com limite de 5 por página
$queryRecentPosts = "
    SELECT posts.*, users.username, COUNT(post_likes.post_id) AS likes_count
    FROM posts
    JOIN users ON posts.user_id = users.id
    LEFT JOIN post_likes ON posts.id = post_likes.post_id
    GROUP BY posts.id
    ORDER BY posts.created_at DESC
    LIMIT :offset, :limit";  // Paginação
$stmtRecentPosts = $pdo->prepare($queryRecentPosts);
$stmtRecentPosts->bindParam(':offset', $offset, PDO::PARAM_INT);
$stmtRecentPosts->bindParam(':limit', $postsPerPage, PDO::PARAM_INT);
$stmtRecentPosts->execute();
$recentPosts = $stmtRecentPosts->fetchAll();

// Contar o número total de posts para calcular as páginas
$queryTotalPosts = "SELECT COUNT(*) FROM posts";
$stmtTotalPosts = $pdo->prepare($queryTotalPosts);
$stmtTotalPosts->execute();
$totalPosts = $stmtTotalPosts->fetchColumn();
$totalPages = ceil($totalPosts / $postsPerPage);


// Recupera o ID da tag filtrada (se houver)
$tagFilter = isset($_GET['tag_id']) ? (int) $_GET['tag_id'] : 0;

// Consulta para os posts com base na tag selecionada
$queryRecentPosts = "
    SELECT posts.*, users.username, COUNT(post_likes.post_id) AS likes_count
    FROM posts
    JOIN users ON posts.user_id = users.id
    LEFT JOIN post_likes ON posts.id = post_likes.post_id
    LEFT JOIN post_tags ON posts.id = post_tags.post_id
    LEFT JOIN tags ON post_tags.tag_id = tags.id
    " . ($tagFilter ? "WHERE tags.id = :tag_id" : "") . "
    GROUP BY posts.id
    ORDER BY posts.created_at DESC
    LIMIT :offset, :limit";  // Paginação

$stmtRecentPosts = $pdo->prepare($queryRecentPosts);

if ($tagFilter) {
    $stmtRecentPosts->bindParam(':tag_id', $tagFilter, PDO::PARAM_INT);
}

$stmtRecentPosts->bindParam(':offset', $offset, PDO::PARAM_INT);
$stmtRecentPosts->bindParam(':limit', $postsPerPage, PDO::PARAM_INT);
$stmtRecentPosts->execute();
$recentPosts = $stmtRecentPosts->fetchAll();

$restricted_words = ['palavra1', 'palavra2', 'palavra3']; // Adicione as palavras que deseja bloquear

// Verifica se há uma mensagem de erro armazenada na sessão
if (isset($_SESSION['restricted_message'])) {
    echo '<div id="message" class="message-restricao">';
    echo $_SESSION['restricted_message'];  
    echo '</div>';
    unset($_SESSION['restricted_message']);  
}

if (isset($_SESSION['sucess_message'])) {
    echo '<div id="message" class="message-sucesso">';
    echo $_SESSION['sucess_message'];  // Exibe a mensagem de erro
    echo '</div>';
    unset($_SESSION['sucess_message']);  // Limpa a mensagem após exibi-la
}


if (isset($_SESSION['alert_message'])) {
    echo '<div id="message" class="message-alerta">';
    echo $_SESSION['alert_message'];  // Exibe a mensagem de erro
    echo '</div>';
    unset($_SESSION['alert_message']);  // Limpa a mensagem após exibi-la
}

// Admin User

?>