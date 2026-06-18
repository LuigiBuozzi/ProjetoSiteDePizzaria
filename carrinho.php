<?php
// carrinho.php
require_once 'includes/header.php';
?>

<h2>Seu Carrinho</h2>

<div id="itens-carrinho"></div>

<h3 style="margin-top: 20px;">Total do Pedido: R$ <span id="total-carrinho">0.00</span></h3>

<hr>

<?php if(isset($_SESSION['usuario_id'])): ?>
    
    <h3>Detalhes da Entrega</h3>
    
    <form action="actions/salvar_pedido.php" method="POST">
        <input type="hidden" name="dados_carrinho" id="dados_carrinho">
        
        <div style="margin-bottom: 10px;">
            <label for="cep">CEP:</label>
            <input type="text" name="cep" id="cep" maxlength="9" required placeholder="00000-000">
        </div>
        
        <div style="margin-bottom: 10px;">
            <label for="endereco">Endereço Completo (Rua, Número, Bairro):</label>
            <input type="text" name="endereco" id="endereco" required style="width: 100%; max-width: 400px;">
        </div>
        
        <button type="submit" style="padding: 10px 20px; font-size: 16px; background-color: #28a745; color: white; border: none; cursor: pointer;">
            Finalizar Pedido
        </button>
    </form>

<?php else: ?>
    
    <div style="background-color: #fff3cd; padding: 15px; border: 1px solid #ffeeba; border-radius: 5px; margin-top: 20px;">
        <p>Para informar o endereço e finalizar sua compra, você precisa estar conectado.</p>
        <a href="login.php" style="display: inline-block; padding: 10px 15px; background-color: #007bff; color: white; text-decoration: none; border-radius: 5px;">Fazer Login</a>
    </div>

<?php endif; ?>

<script src="assets/js/carrinho.js"></script>
<script src="assets/js/viacep.js"></script> ```

<?php require_once 'includes/footer.php'; ?>