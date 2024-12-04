<?php
include('db.php');

// Pega o termo de busca passado via GET
$searchQuery = isset($_GET['q']) ? $_GET['q'] : '';

// Define o número de resultados por página
$postsPerPage = 5; // Ajuste conforme necessário

// Pega o número da página atual
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) {
    $page = 1;
}

// Calcula o offset para a consulta SQL
$offset = ($page - 1) * $postsPerPage;

// Se a consulta não for vazia, faz a busca no banco
if (!empty($searchQuery)) {
    // Consulta para contar o número total de posts que correspondem à busca
    $countQuery = "
        SELECT COUNT(*) 
        FROM posts
        JOIN users ON posts.user_id = users.id
        WHERE posts.content LIKE :searchQuery";
    $stmt = $pdo->prepare($countQuery);
    $stmt->execute(['searchQuery' => '%' . $searchQuery . '%']);
    $totalPosts = $stmt->fetchColumn(); // Número total de posts

    // Consulta para pegar os posts com limite e offset para paginação
    $query = "
        SELECT posts.*, users.username, COUNT(post_likes.post_id) AS likes_count 
        FROM posts
        JOIN users ON posts.user_id = users.id
        LEFT JOIN post_likes ON posts.id = post_likes.post_id
        WHERE posts.content LIKE :searchQuery
        GROUP BY posts.id
        ORDER BY posts.created_at DESC
        LIMIT :offset, :limit";
    
    // Ajuste: Passando parâmetros numéricos corretamente para LIMIT e OFFSET
    $stmt = $pdo->prepare($query);
    $stmt->bindValue(':searchQuery', '%' . $searchQuery . '%', PDO::PARAM_STR);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->bindValue(':limit', $postsPerPage, PDO::PARAM_INT);
    $stmt->execute();
    $posts = $stmt->fetchAll();

    if ($posts) {
        foreach ($posts as $post) {
            // Garantir que os campos necessários existam no array
            $postId = isset($post['id']) ? intval($post['id']) : 0;
            $postTitle = isset($post['content']) ? htmlspecialchars($post['content']) : 'Sem título';
            $postUsername = isset($post['username']) ? htmlspecialchars($post['username']) : 'Anônimo';
            $likesCount = isset($post['likes_count']) ? intval($post['likes_count']) : 0;
    
            // Se o post não tiver um ID válido, ignorar este item
            if ($postId > 0) {
                echo "<div class='search-card'>
                        <a href='search_results.php?post_id=$postId'>
                            <strong>" . $postUsername . "</strong><br>
                            <span>" . $postTitle . "</span><br>
                            <small>Likes: " . $likesCount . "</small>
                        </a>
                      </div>";
            } else {
                echo "<div class='search-card'>
                        <strong>Post inválido</strong>
                      </div>";
            }
        }
    } else {
        echo "<p>Nenhum resultado encontrado.</p>";
    }
    

    // Calcula o total de páginas
    $totalPages = ceil($totalPosts / $postsPerPage);

}
?>
