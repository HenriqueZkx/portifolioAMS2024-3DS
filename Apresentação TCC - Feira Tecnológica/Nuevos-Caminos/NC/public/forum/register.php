<?php
include('db.php');
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $email = $_POST['email'];

    // Verificar se o e-mail já está em uso
    $query = "SELECT * FROM users WHERE email = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user) {
        $_SESSION['error'] = "E-mail já está em uso.";
    } else {
        // Inserir o novo usuário no banco de dados
        $query = "INSERT INTO users (username, password, email) VALUES (?, ?, ?)";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$username, $password, $email]);

        header('Location: login.php');
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Cadastro - NC-Foro</title>
    <style>
        body, html {
            height: 100%;
            margin: 0;
            font-family: Arial, sans-serif;
        }

        main#main {
            width: 100%;
            height: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            background: url(img/cadastre.jpeg) no-repeat center center fixed;
            background-size: cover;
        }

        #register-right {
            max-width: 700px;
            background: rgba(255, 255, 255, 0.9);
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            position: relative;
        }

        .alert {
            position: absolute;
            top: -20px;
            left: 50%;
            transform: translate(-50%, -100%);
            width: 90%;
            max-width: 600px;
            background-color: rgba(255, 0, 0, 0.8);
            color: white;
            padding: 10px;
            border-radius: 5px;
            text-align: center;
            font-weight: bold;
            animation: fadeIn 0.5s ease-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        .card { width: 100%; background: transparent; }
        .form-group { margin-bottom: 15px; text-align: center; }
        .form-control {
            text-align: center;
            width: 80%;
            max-width: 100%;
            border-radius: 10px;
            padding: 10px;
            margin: auto;
            background-color: #c2c2c2;
            color: #fff;
        }
        .btn-sm { background-color: #827e96; border: none; color: white; padding: 8px 16px; border-radius: 20px; font-size: 14px; }
        .btn-link { color: #5d5a6b; text-decoration: none; font-size: 14px; }
        .action-buttons { display: flex; align-items: center; justify-content: center; gap: 10px; }
    </style>
</head>

<body>
    <main id="main">
        <div id="register-right">
            <?php if (isset($_SESSION['error'])): ?>
                <div class="alert">
                    <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
                </div>
            <?php endif; ?>
            
            <div class="card">
                <div class="card-body">
                    <form action="register.php" method="POST" onsubmit="return validateForm()">
                        <div class="form-group">
                            <label for="username" class="control-label">Nome de usuário</label><br>
                            <input type="text" id="username" name="username" class="form-control" minlength="2" required>
                        </div>
                        <div class="form-group">
                            <label for="email" class="control-label">Email</label><br>
                            <input type="email" id="email" name="email" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="password" class="control-label">Senha</label><br>
                            <input type="password" id="password" name="password" class="form-control" required>
                        </div>
                        <div class="action-buttons">
                            <button type="submit" class="btn-sm">Cadastrar</button>
                            <a href="login.php" class="btn-link">Já tem uma conta?</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>

    <script>
        function validateForm() {
            const password = document.getElementById("password").value;
            const username = document.getElementById("username").value;

            if (username.length < 2) {
                alert("O nome de usuário deve ter pelo menos 2 caracteres.");
                return false;
            }

            const passwordRegex = /^(?=.*[A-Z])(?=.*\d).{5,}$/;
            if (!passwordRegex.test(password)) {
                alert("A senha deve ter pelo menos 5 caracteres, incluindo uma letra maiúscula e um número.");
                return false;
            }

            return true;
        }
    </script>
</body>
</html>
