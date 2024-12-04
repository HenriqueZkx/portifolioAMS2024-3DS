<?php
include('db.php');

// Verifica se o ID do post foi passado
if (isset($_GET['post_id'])) {
    $postId = $_GET['post_id'];

    // Recupera as tags associadas ao post
    $query = "SELECT tags.name FROM post_tags 
              JOIN tags ON post_tags.tag_id = tags.id
              WHERE post_tags.post_id = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$postId]);

    // Recupera as tags
    $tags = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Retorna as tags em formato JSON
    echo json_encode($tags);
}
?>
