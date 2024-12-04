<?php
include('db.php');
session_start();

// Processo de cadastro
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register'])) {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $email = $_POST['email'];

    // Verificar se o nome de usuário já está em uso
    $query = "SELECT * FROM users WHERE username = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user) {
        $_SESSION['error'] = "Nome de usuário já está em uso. Por favor, escolha outro.";
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit();
    }

    // Verificar se o e-mail já está em uso
    $query = "SELECT * FROM users WHERE email = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user) {
        $_SESSION['error'] = "E-mail já está em uso. Por favor, escolha outro.";
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit();
    }

    // Inserir novo usuário
    $query = "INSERT INTO users (username, password, email) VALUES (?, ?, ?)";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$username, $password, $email]);
    header('Location: index.php');
    exit();
}
// Processo de login
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Buscar usuário no banco de dados
    $query = "SELECT * FROM users WHERE username = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        // Iniciar sessão com o ID e nome de usuário
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];

        // Verificar se o usuário é o admin
        if ($user['username'] === 'admin') {
            header('Location: admin.php'); // Redireciona para o painel de admin
        } else {
            header('Location: index.php'); // Redireciona para a página inicial
        }
        exit();
    } else {
        // Envia o erro para ser exibido no alerta visual
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                showAlert('Nombre de usuario o contraseña no válidos.');
            });
        </script>";
    }
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Registro e inicio de sesión</title>
    <style>
        body,
        html {
            height: 100%;
            margin: 0;
            font-family: Arial, sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #827e96 50%, #5d5a6b 50%);
            background-size: cover;
            overflow: hidden;
        }


        .form-container {
            width: 100%;
            max-width: 400px;
            padding: 30px;
            background: rgba(255, 255, 255, 0.9);
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            overflow: hidden;
            /* Garante que os elementos animados não "vazem" */
            transition: height 0.6s cubic-bezier(0.4, 0, 0.2, 1), transform 0.3s ease;
            transform: scale(1);
            /* Para a animação de foco */
        }

        .form-container:hover {
            transform: scale(1.03);
            /* Leve aumento no hover */
        }

        .form-container.register-view {
            height: 340px;
        }

        .form-container.login-view {
            height: 280px;
        }

        .form-section {
            display: none;
            opacity: 0;
            transform: translateY(20px);
            /* Move os elementos para baixo inicialmente */
            transition: opacity 0.6s ease, transform 0.6s ease;
        }

        .form-container.register-view .register-form {
            display: block;
            opacity: 1;
            transform: translateY(0);
            /* Elemento volta à posição normal */
        }

        .form-container.login-view .login-form {
            display: block;
            opacity: 1;
            transform: translateY(0);
            /* Elemento volta à posição normal */
        }

        .form-group {
            margin-bottom: 15px;
            text-align: center;
            transition: transform 0.5s ease, opacity 0.5s ease;
            /* Animação adicional */
        }

        .form-group:hover {
            transform: scale(1.02);
            opacity: 0.95;
            /* Leve destaque no hover */
        }

        .form-control {
            width: 80%;
            border-radius: 10px;
            padding: 10px;
            margin: auto;
            background-color: #c2c2c2;
            color: #fff;
            text-align: center;
            transition: background-color 0.3s ease, box-shadow 0.3s ease;
        }

        .form-control:focus {
            background-color: #a9a9a9;
            /* Cor de foco */
            box-shadow: 0 0 8px rgba(130, 126, 150, 0.5);
            /* Brilho ao redor */
        }


        .btn-sm {
            background-color: #827e96;
            border: none;
            color: white;
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 14px;
            transition: all 0.3s ease;
            /* Adiciona uma transição suave */
        }

        .btn-sm:hover {
            background-color: #5d5a6b;
            color: #fff;
            transform: scale(1.1);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
        }


        .btn-link {
            color: #5d5a6b;
            text-decoration: none;
            font-size: 14px;
            cursor: pointer;
        }

        .action-buttons {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .alert {
            background-color: rgba(255, 0, 0, 0.8);
            color: white;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 5px;
            text-align: center;
            font-size: 14px;
            position: absolute;
            top: 10px;
            width: calc(100% - 20px);
            left: 50%;
            transform: translateX(-50%);
            z-index: 1000;
        }
    </style>
</head>

<body>
<?php if (isset($_SESSION['error'])): ?>
                <div class="alert">
                    <?php echo $_SESSION['error'];
                    unset($_SESSION['error']); ?>
                </div>
            <?php endif; ?>
    <div class="form-container login-view" id="formContainer">
    
        <!-- Formulário de Cadastro -->
        <div class="form-section register-form">
            <h2 style="text-align: center;">Formulario de registro</h2>
            
            <form action="" method="POST" onsubmit="return validateForm()">
                <input type="hidden" name="register" value="1">
                <div class="form-group">
                    <label for="username">Nombe del usuario</label><br>
                    <input type="text" id="username" name="username" class="form-control" minlength="2" required>
                </div>
                <div class="form-group">
                    <label for="email">Correo electrónico</label><br>
                    <input type="email" id="email" name="email" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="password">Contraseña</label><br>
                    <input type="password" id="password" name="password" class="form-control" required>
                </div>
                <div class="action-buttons">
                    <button type="submit" class="btn-sm">Registro</button>
                    <span class="btn-link" onclick="showLogin()">¿Ya tienes una cuenta? Entrar</span>
                </div>
            </form>
        </div>

        <!-- Formulário de Login -->
        <div class="form-section login-form">
            <h2 style="text-align: center;">Iniciar sesión</h2>
            <?php if (isset($_SESSION['login_error'])): ?>
                <div class="alert">
                    <?php echo $_SESSION['login_error'];
                    unset($_SESSION['login_error']); ?>
                </div>
            <?php endif; ?>
            <form action="" method="POST">
                <input type="hidden" name="login" value="1">
                <div class="form-group">
                    <label for="username">Nombre del usuario</label><br>
                    <input type="text" id="username" name="username" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="password">Contraseña</label><br>
                    <input type="password" id="password" name="password" class="form-control" required>
                </div>
                <div class="action-buttons">
                    <button type="submit" class="btn-sm">Entrar</button>
                    <span class="btn-link" onclick="showRegister()">Regístrese aquí</span>
                </div>
            </form>
        </div>
    </div>

    <script>
        const formContainer = document.getElementById('formContainer');

        function showRegister() {
            formContainer.classList.add('register-view');
            formContainer.classList.remove('login-view');
        }

        function showLogin() {
            formContainer.classList.add('login-view');
            formContainer.classList.remove('register-view');
        }

        function validateForm() {
            const username = document.getElementById("username").value.trim();
            const email = document.getElementById("email").value.trim();
            const password = document.getElementById("password").value.trim();

            if (!username || !email || !password) {
                showAlert("Todos los campos del formulario son obligatorios.");
                return false;
            }

            if (username.length < 2) {
                showAlert("El nombre de usuario debe tener al menos 2 caracteres.");
                return false;
            }

            const passwordRegex = /^(?=.*[A-Z])(?=.*\d).{5,}$/;
            if (!passwordRegex.test(password)) {
                showAlert("La contraseña debe tener al menos 5 caracteres, incluyendo una letra mayúscula y un número.");
                return false;
            }

            return true;
        }

        function showAlert(message) {
            const existingAlert = document.querySelector(".alert");
            if (existingAlert) {
                existingAlert.remove();
            }

            const alertDiv = document.createElement("div");
            alertDiv.className = "alert";
            alertDiv.textContent = message;
            document.body.appendChild(alertDiv);

            setTimeout(() => {
                alertDiv.remove();
            }, 3000);
        }


        function showAlert(message) {
            const existingAlert = document.querySelector(".alert");
            if (existingAlert) {
                existingAlert.remove();
            }

            const alertDiv = document.createElement("div");
            alertDiv.className = "alert";
            alertDiv.textContent = message;
            alertDiv.style.position = "fixed";
            alertDiv.style.top = "10px";
            alertDiv.style.left = "50%";
            alertDiv.style.transform = "translateX(-50%)";
            alertDiv.style.backgroundColor = "rgba(255, 0, 0, 0.8)";
            alertDiv.style.color = "white";
            alertDiv.style.padding = "10px 20px";
            alertDiv.style.borderRadius = "5px";
            alertDiv.style.boxShadow = "0 4px 6px rgba(0, 0, 0, 0.2)";
            alertDiv.style.zIndex = "1000";

            document.body.appendChild(alertDiv);

            // Remove o alerta após 3 segundos
            setTimeout(() => {
                alertDiv.remove();
            }, 3000);
        }
    </script>

</body>

</html>