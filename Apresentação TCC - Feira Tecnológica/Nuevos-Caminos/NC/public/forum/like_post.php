<?php
session_start();
include('db.php');

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $postId = $_POST['post_id'];
    $userId = $_SESSION['user_id'];

    // Verifica se o usuário já deu like neste post
    $queryCheck = "SELECT 1 FROM post_likes WHERE post_id = ? AND user_id = ?";
    $stmtCheck = $pdo->prepare($queryCheck);
    $stmtCheck->execute([$postId, $userId]);
    
    if ($stmtCheck->fetchColumn()) {
        // O usuário já curtiu o post
        header('Location: forum.php');
        exit;
    }

    // Registra o like
    $queryInsert = "INSERT INTO post_likes (post_id, user_id) VALUES (?, ?)";
    $stmtInsert = $pdo->prepare($queryInsert);
    $stmtInsert->execute([$postId, $userId]);

    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit;
}
?>
