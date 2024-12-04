<?php
session_start();
include(__DIR__ . '/../db.php');


// Verifica se o usuário está autenticado
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// Lidar com a exclusão de usuários
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_user_id'])) {
    $deleteUserId = $_POST['delete_user_id'];

    // Verificar se o usuário tem permissão para excluir este usuário (ou seja, não se é o próprio)
    if ($deleteUserId != $_SESSION['user_id']) {
        try {
            // Excluir registros dependentes antes de excluir o usuário
            $stmt = $pdo->prepare("DELETE FROM post_likes WHERE user_id = ?");
            $stmt->execute([$deleteUserId]);

            // Excluir o usuário da tabela de usuários
            $stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
            $stmt->execute([$deleteUserId]);

            $_SESSION['success_message'] = "O usuário foi deletado com sucesso!";
        } catch (PDOException $e) {
            $_SESSION['error_message'] = "Erro ao excluir o usuário: " . $e->getMessage();
        }
    } else {
        $_SESSION['error_message'] = "Você não pode excluir sua própria conta!";
    }

    // Redireciona de volta para a mesma página
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit;
}

// Buscar usuários com base na pesquisa
$users = [];
$searchQuery = isset($_POST['search']) ? trim($_POST['search']) : '';

// Definindo o número de usuários por página
$usersPerPage = 6;

// Página atual
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

// Verificando a página mínima
if ($page < 1) $page = 1;

// Consultando o total de usuários
if ($searchQuery) {
    // Busca os usuários com base na pesquisa (usando LIKE para encontrar nomes similares)
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE username LIKE :searchQuery");
    $searchParam = '%' . $searchQuery . '%'; 
    $stmt->bindParam(':searchQuery', $searchParam, PDO::PARAM_STR);
    $stmt->execute();
} else {
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM users");
    $stmt->execute();
}

$totalUsers = $stmt->fetchColumn();
$totalPages = ceil($totalUsers / $usersPerPage);

// Evita páginas acima do limite
if ($page > $totalPages) $page = $totalPages;

// Calculando o limite de usuários para a consulta
$offset = ($page - 1) * $usersPerPage;

// Garante que o offset nunca será negativo
if ($offset < 0) $offset = 0;

// Consultando os usuários para a página atual (com filtro de pesquisa, se existir)
if ($searchQuery) {
    $stmt = $pdo->prepare("SELECT id, username, email FROM users WHERE username LIKE :searchQuery LIMIT :offset, :usersPerPage");
    $stmt->bindParam(':searchQuery', $searchParam, PDO::PARAM_STR);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT); // Usar bindValue para números
    $stmt->bindValue(':usersPerPage', $usersPerPage, PDO::PARAM_INT); // Usar bindValue para números
    $stmt->execute();
} else {
    $stmt = $pdo->prepare("SELECT id, username, email FROM users LIMIT :offset, :usersPerPage");
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT); // Usar bindValue para números
    $stmt->bindValue(':usersPerPage', $usersPerPage, PDO::PARAM_INT); // Usar bindValue para números
    $stmt->execute();
}

$users = $stmt->fetchAll();

// Verifica se não encontrou nenhum usuário
if (empty($users) && $searchQuery) {
    // Define a mensagem de erro
    $_SESSION['error_message'] = 'Usuário inexistente!';

    // Redireciona de volta para a mesma página
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit;
}
?>

