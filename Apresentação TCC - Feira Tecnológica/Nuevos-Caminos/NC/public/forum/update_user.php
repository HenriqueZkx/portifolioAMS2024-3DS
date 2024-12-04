<?php
session_start();
include('db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $newUsername = trim($_POST['username']);
    $newPassword = $_POST['password'];
    $confirmPassword = $_POST['confirm-password'];

    // Verifica se as senhas coincidem, se o campo de senha foi preenchido
    if ($newPassword !== '' && $newPassword !== $confirmPassword) {
        $_SESSION['restricted_message'] = "As senhas não coincidem.";
        // Redirecionar de volta para o formulário com a mensagem de erro
        header('Location: index.php');
        exit;
    }


    // Verifica se a senha tem pelo menos 5 caracteres, 1 letra maiúscula e 1 caractere especial
    if (!preg_match('/^(?=.*[A-Z])(?=.*[!@#$%^&*(),.?":{}|<>])[A-Za-z\d!@#$%^&*(),.?":{}|<>]{5,}$/', $newPassword)) {
        $_SESSION['alert_message'] = "La contraseña debe tener al menos 5 caracteres, incluyendo una letra mayúscula y un carácter especial.";
        // Redirecionar de volta para o formulário com a mensagem de erro
        header('Location: index.php');
        exit;
    }

    // Verifica se o nome de usuário já existe, mas ignora o nome de usuário do próprio usuário
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ? AND id != ?");
    $stmt->execute([$newUsername, $_SESSION['user_id']]);
    $existingUser = $stmt->fetch();

    if ($existingUser) {
        $_SESSION['restricted_message'] = "Nome de usuário já existe.";
        // Redirecionar de volta para o formulário com a mensagem de erro
        header('Location: index.php');
        exit;
    }

    // Se o usuário não forneceu uma nova senha, usa a senha antiga
    if ($newPassword === '') {
        // Recupera a senha atual do banco de dados
        $stmt = $pdo->prepare("SELECT password FROM users WHERE id = ?");
        $stmt->execute([$_SESSION['user_id']]);
        $currentUser = $stmt->fetch();
        $newPassword = $currentUser['password']; // Mantém a senha atual
    } else {
        // Se a senha foi alterada, faz o hash
        $newPassword = password_hash($newPassword, PASSWORD_DEFAULT);
    }

    // Atualiza o nome de usuário na tabela users
    $stmt = $pdo->prepare("UPDATE users SET username = ?, password = ? WHERE id = ?");
    $stmt->execute([$newUsername, $newPassword, $_SESSION['user_id']]);

    // Atualiza o nome de usuário nas respostas (se necessário)
    $stmt = $pdo->prepare("UPDATE replies SET username = ? WHERE username = ?");
    $stmt->execute([$newUsername, $_SESSION['username']]);

    // Atualiza a sessão com o novo nome de usuário
    $_SESSION['username'] = $newUsername;

    // Redireciona de volta para a página principal com sucesso
    $_SESSION['success_message'] = "Alterações realizadas com sucesso!";
    header('Location: index.php');
    exit;
}
?>
