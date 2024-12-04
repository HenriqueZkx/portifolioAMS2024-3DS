<?php
session_start();
include('db.php');

// Verificar se o usuário está logado
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// Verificar se o ID do post foi passado
if (isset($_GET['id'])) {
    $postId = $_GET['id'];

    try {
        // Iniciar a transação
        $pdo->beginTransaction();

        // Excluir as respostas associadas ao post
        $deleteRepliesQuery = "DELETE FROM replies WHERE post_id = ?";
        $stmtDeleteReplies = $pdo->prepare($deleteRepliesQuery);
        $stmtDeleteReplies->execute([$postId]);

        // Agora excluir o post
        $deletePostQuery = "DELETE FROM posts WHERE id = ?";
        $_SESSION['sucess_message'] = "Tu publicación fue eliminada exitosamente.";
        $stmtDeletePost = $pdo->prepare($deletePostQuery);
        $stmtDeletePost->execute([$postId]);

        // Commit da transação
        $pdo->commit();

        // Redirecionar após exclusão
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit;

    } catch (Exception $e) {
        // Em caso de erro, desfazer a transação
        $pdo->rollBack();
        echo "Erro: " . $e->getMessage();
    }
} else {
    echo "ID do post não fornecido.";
}
?>
