<?php
// get_post_content.php
include 'db.php';  // Conexão com o banco de dados

session_start();

if (isset($_GET['id'])) {
    $postId = $_GET['id'];
    
    // Recupera os dados do post
    $stmt = $pdo->prepare("SELECT * FROM posts WHERE id = ?");
    $stmt->execute([$postId]);
    $post = $stmt->fetch();

    if ($post) {
        // Exibe o conteúdo do post
        echo "<h2>{$post['username']}</h2>";
        echo "<p>{$post['content']}</p>";
        echo "<h6>Publicado em: {$post['created_at']}</h6>";

        // Recupera as respostas para este post
        $stmtReplies = $pdo->prepare("SELECT * FROM replies WHERE post_id = ? ORDER BY created_at DESC");
        $stmtReplies->execute([$postId]);
        $replies = $stmtReplies->fetchAll();

        // Exibe as respostas
        if ($replies) {
            echo "<h3>Respostas:</h3>";
            foreach ($replies as $reply) {
                echo "<div class='response'>";
                echo "<strong>{$reply['username']} - {$reply['created_at']}</strong>";
                echo "<p>{$reply['content']}</p>";
                // Exibe os botões de editar e excluir para o criador da resposta
                echo "</div>";
            }
        } else {
            echo "<p>Este post ainda não tem respostas.</p>";
        }

        // Formulário para adicionar uma resposta ao post
        echo "<h4>Responder ao post:</h4>";
        echo "<form action='submit_reply.php' method='POST'>
                <textarea name='content' placeholder='Escreva sua resposta...' required></textarea><br>
                <input type='hidden' name='post_id' value='{$post['id']}'>
                <button type='submit'>Responder</button>
              </form>";
    } else {
        echo "Post não encontrado!";
    }
}
?>

<?php include './js/script.php'; ?>
