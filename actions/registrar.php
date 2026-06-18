<?php
// actions/registrar.php
session_start();
require_once '../config/database.php'; // Cuidado com o '../' para voltar uma pasta

// Verifica se os dados realmente chegaram via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // Recebe os dados do formulário
    $nome = trim($_POST['nome']);
    $email = trim($_POST['email']);
    $senha = $_POST['senha'];

    // Validação básica
    if (empty($nome) || empty($email) || empty($senha)) {
        die("Todos os campos são obrigatórios.");
    }

    try {
        // 1º Passo: Verificar se o email já existe no banco
        $stmt = $pdo->prepare("SELECT id FROM usuarios WHERE email = ?");
        $stmt->execute([$email]);
        
        if ($stmt->rowCount() > 0) {
            die("Este e-mail já está cadastrado.");
        }

        // 2º Passo: Criptografar a senha (NUNCA salve senhas em texto puro)
        $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

        // 3º Passo: Inserir o usuário no PostgreSQL
        $sql = "INSERT INTO usuarios (nome, email, senha) VALUES (?, ?, ?)";
        $stmtInserir = $pdo->prepare($sql);
        $stmtInserir->execute([$nome, $email, $senhaHash]);

        // Se deu tudo certo, redireciona o usuário para a tela de login
        header("Location: ../login.php?sucesso=1");
        exit;

    } catch (PDOException $e) {
        die("Erro ao cadastrar: " . $e->getMessage());
    }
} else {
    // Se tentarem acessar este arquivo diretamente pela URL, manda de volta pro cadastro
    header("Location: ../cadastro.php");
    exit;
}
?>