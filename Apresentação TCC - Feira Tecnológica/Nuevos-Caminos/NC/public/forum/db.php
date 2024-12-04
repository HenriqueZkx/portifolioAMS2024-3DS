<?php
$host = 'localhost';
$dbname = 'forum';
$username = 'root'; // Substitua pelo seu usuário de banco de dados
$password = ''; // Substitua pela sua senha de banco de dados

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Erro de conexão: ' . $e->getMessage();
}
?>
