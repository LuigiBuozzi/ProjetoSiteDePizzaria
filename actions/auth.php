<?php
// actions/auth.php
session_start();
require_once '../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $senha = $_POST['senha'];

    if (empty($email) || empty($senha)) {
        die("Preencha todos os campos.");
    }

    try {
        // Busca o usuário pelo e-mail
        $stmt = $pdo->prepare("SELECT id, nome, senha, is_admin FROM usuarios WHERE email = ?");
        $stmt->execute([$email]);
        $usuario = $stmt->fetch();

        // Verifica se o usuário existe e se a senha bate com o hash do banco
        if ($usuario && password_verify($senha, $usuario['senha'])) {
            
            // Login com sucesso! Criamos a sessão do usuário.
            $_SESSION['usuario_id'] = $usuario['id'];
            $_SESSION['usuario_nome'] = $usuario['nome'];
            $_SESSION['is_admin'] = $usuario['is_admin'];

            // Redireciona de volta para a página inicial (Cardápio)
            header("Location: ../index.php");
            exit;
            
        } else {
            // Login falhou (usuário não existe ou senha errada)
            header("Location: ../login.php?erro=1");
            exit;
        }

    } catch (PDOException $e) {
        die("Erro ao tentar fazer login: " . $e->getMessage());
    }
} else {
    header("Location: ../login.php");
    exit;
}
?>