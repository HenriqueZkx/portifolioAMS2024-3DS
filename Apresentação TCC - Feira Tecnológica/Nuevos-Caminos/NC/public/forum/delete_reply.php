<?php
session_start();
include('db.php');

// Verifica se o usuário está logado
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

if (isset($_GET['id'])) {
    $replyId = $_GET['id'];

    // Verificar se a resposta pertence ao usuário logado
    $query = "SELECT user_id FROM replies WHERE id = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$replyId]);
    $reply = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($reply && $reply['user_id'] == $_SESSION['user_id']) {
        // Deletar a resposta
        $deleteQuery = "DELETE FROM replies WHERE id = ?";
        $_SESSION['sucess_message'] = "Tu respuesta fue eliminada exitosamente.";
        $deleteStmt = $pdo->prepare($deleteQuery);
        $deleteStmt->execute([$replyId]);

        // Redireciona de volta para o post
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit;
    } else {
        echo "Você não tem permissão para excluir esta resposta.";
    }
}
?>
