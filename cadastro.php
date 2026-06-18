<?php
// cadastro.php
require_once 'includes/header.php';
?>

<h2>Criar uma Conta</h2>

<form action="actions/registrar.php" method="POST" class="form-auth">
    <div>
        <label for="nome">Nome Completo:</label>
        <input type="text" id="nome" name="nome" required>
    </div>
    
    <div>
        <label for="email">E-mail:</label>
        <input type="email" id="email" name="email" required>
    </div>
    
    <div>
        <label for="senha">Senha:</label>
        <input type="password" id="senha" name="senha" required>
    </div>
    
    <button type="submit">Cadastrar</button>
</form>

<p>Já tem uma conta? <a href="login.php">Faça login aqui</a>.</p>

<?php require_once 'includes/footer.php'; ?>