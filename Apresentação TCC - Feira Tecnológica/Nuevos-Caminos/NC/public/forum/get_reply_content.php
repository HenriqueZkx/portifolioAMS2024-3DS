<?php
session_start();
include('db.php');

if (isset($_GET['id'])) {
    $replyId = $_GET['id'];

    // Recuperar o conteúdo da resposta
    $query = "SELECT content FROM replies WHERE id = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$replyId]);

    $reply = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($reply) {
        echo json_encode($reply);
    } else {
        echo json_encode(['error' => 'Resposta não encontrada.']);
    }
}
?>
