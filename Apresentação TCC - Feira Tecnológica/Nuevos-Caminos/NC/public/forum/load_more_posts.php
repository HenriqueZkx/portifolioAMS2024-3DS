<?php
session_start();
include('db.php');

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// Pegando os posts a partir do 6º
$query = "SELECT posts.*, users.username 
          FROM posts
          JOIN users ON posts.user_id = users.id
          ORDER BY posts.created_at DESC
          LIMIT 3, 3";  // Paginação, carregando os próximos 5
$stmt = $pdo->prepare($query);
$stmt->execute();
$posts = $stmt->fetchAll();

$postsArray = [];
foreach ($posts as $post) {
    $postsArray[] = [
        'id' => $post['id'],
        'username' => $post['username'],
        'content' => $post['content'],
        'created_at' => $post['created_at']
    ];
}

echo json_encode($postsArray);
?>
