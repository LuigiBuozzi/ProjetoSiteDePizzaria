<?php
// actions/salvar_pedido.php
session_start();
require_once '../config/database.php';

// Proteção: apenas usuários logados podem fazer pedidos
if (!isset($_SESSION['usuario_id'])) {
    die("Você precisa estar logado para finalizar um pedido.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario_id = $_SESSION['usuario_id'];
    $cep = trim($_POST['cep']);
    $endereco = trim($_POST['endereco']);
    $carrinho_json = $_POST['dados_carrinho'];

    // Transforma o JSON do JavaScript em um Array do PHP
    $itens = json_decode($carrinho_json, true);

    if (empty($itens)) {
        die("Seu carrinho está vazio.");
    }

    try {
        // Inicia a Transação
        $pdo->beginTransaction();

        // 1. Calcula o total do pedido consultando o banco (por segurança, não confiamos no preço vindo do HTML)
        $total_pedido = 0;
        $itens_processados = [];

        foreach ($itens as $item) {
            $stmt = $pdo->prepare("SELECT preco FROM produtos WHERE id = ?");
            $stmt->execute([$item['id']]);
            $produto_db = $stmt->fetch();

            if ($produto_db) {
                $subtotal = $produto_db['preco'] * $item['quantidade'];
                $total_pedido += $subtotal;
                
                // Guarda o preço real para usar no próximo INSERT
                $itens_processados[] = [
                    'produto_id' => $item['id'],
                    'quantidade' => $item['quantidade'],
                    'preco_unitario' => $produto_db['preco']
                ];
            }
        }

        // 2. Insere o pedido na tabela principal
        // No PostgreSQL, usamos RETURNING id para pegar o ID que acabou de ser gerado
        $sqlPedido = "INSERT INTO pedidos (usuario_id, total, cep, endereco_completo) 
                      VALUES (?, ?, ?, ?) RETURNING id";
        $stmtPedido = $pdo->prepare($sqlPedido);
        $stmtPedido->execute([$usuario_id, $total_pedido, $cep, $endereco]);
        
        $resultadoPedido = $stmtPedido->fetch();
        $pedido_id = $resultadoPedido['id']; // Pegamos o ID do pedido gerado

        // 3. Insere os itens na tabela de relação
        $sqlItem = "INSERT INTO itens_pedido (pedido_id, produto_id, quantidade, preco_unitario) 
                    VALUES (?, ?, ?, ?)";
        $stmtItem = $pdo->prepare($sqlItem);

        foreach ($itens_processados as $ip) {
            $stmtItem->execute([$pedido_id, $ip['produto_id'], $ip['quantidade'], $ip['preco_unitario']]);
        }

        // Se chegou até aqui sem erros, confirma as alterações no banco!
        $pdo->commit();

        // Redireciona para o histórico de pedidos avisando que deu certo
        header("Location: ../meus_pedidos.php?sucesso=1");
        exit;

    } catch (Exception $e) {
        // Se der erro em qualquer INSERT, desfaz tudo
        $pdo->rollBack();
        die("Erro ao processar seu pedido: " . $e->getMessage());
    }
} else {
    header("Location: ../carrinho.php");
    exit;
}
?>