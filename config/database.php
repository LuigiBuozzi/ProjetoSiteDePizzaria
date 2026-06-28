<?php
// config/database.php

$host = 'localhost';
$dbname = 'pizzaria'; // Mude se o nome do seu banco for diferente
$user = 'postgres';        // Seu usuário do Postgres
$password = '1234';    // Sua senha do Postgres

try {
    // String de conexão DSN para PostgreSQL
    $dsn = "pgsql:host=$host;port=5432;dbname=$dbname";
    
    // Criando a instância do PDO
    $pdo = new PDO($dsn, $user, $password);
    
    // Configurando o PDO para lançar exceções em caso de erros
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Configurando o fetch padrão para retornar arrays associativos
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    // Em caso de erro, interrompe a execução e exibe a mensagem
    die("Erro na conexão com o banco de dados: " . $e->getMessage());
}
?>
