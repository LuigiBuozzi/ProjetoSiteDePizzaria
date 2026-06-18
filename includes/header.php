<?php
// includes/header.php
// Inicia a sessão apenas se ela ainda não tiver sido iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pizzaria TADS</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <header>
        <h1>🍕 Pizzaria TADS</h1>
        <nav>
            <a href="index.php">Cardápio</a>
            <a href="carrinho.php">Carrinho</a>
            
            <?php if(isset($_SESSION['usuario_id'])): ?>
                <a href="meus_pedidos.php">Meus Pedidos</a>
                <a href="actions/logout.php">Sair</a>
            <?php else: ?>
                <a href="login.php">Entrar</a>
            <?php endif; ?>
        </nav>
    </header>
    <main>