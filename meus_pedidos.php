<?php
// meus_pedidos.php
require_once 'includes/header.php';

// Se não estiver logado, manda pro login
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}

require_once 'config/database.php';
$usuario_id = $_SESSION['usuario_id'];

// Busca os pedidos do usuário ordenados do mais recente para o mais antigo
$stmt = $pdo->prepare("SELECT * FROM pedidos WHERE usuario_id = ? ORDER BY data_pedido DESC");
$stmt->execute([$usuario_id]);
$pedidos = $stmt->fetchAll();
?>

<h2>Meus Pedidos</h2>

<?php if (isset($_GET['sucesso'])): ?>
    <div style="background-color: #d4edda; color: #155724; padding: 15px; border-radius: 5px; margin-bottom: 20px;">
        <strong>Sucesso!</strong> Seu pedido foi recebido e já está sendo preparado.
    </div>

    <script>
        localStorage.removeItem('carrinho');
    </script>
<?php endif; ?>

<?php if (count($pedidos) === 0): ?>
    <p>Você ainda não fez nenhum pedido conosco. Que tal <a href="index.php">olhar nosso cardápio</a>?</p>
<?php else: ?>
    
    <table border="1" style="width: 100%; text-align: left; border-collapse: collapse;">
        <thead>
            <tr>
                <th>Número do Pedido</th>
                <th>Data</th>
                <th>Status</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($pedidos as $pedido): ?>
                <tr>
                    <td>#<?php echo str_pad($pedido['id'], 5, '0', STR_PAD_LEFT); ?></td>
                    <td><?php echo date('d/m/Y H:i', strtotime($pedido['data_pedido'])); ?></td>
                    <td><strong><?php echo htmlspecialchars($pedido['status']); ?></strong></td>
                    <td>R$ <?php echo number_format($pedido['total'], 2, ',', '.'); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

<?php endif; ?>

<?php require_once 'includes/footer.php'; ?>