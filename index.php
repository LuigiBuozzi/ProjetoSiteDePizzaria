<?php
// index.php
require_once 'config/database.php'; // Conecta ao banco
require_once 'includes/header.php'; // Traz o topo do site

// Prepara e executa a busca de produtos
$stmt = $pdo->query("SELECT * FROM produtos ORDER BY id ASC");
$produtos = $stmt->fetchAll();
?>

<h2>Nosso Cardápio</h2>

<div class="grid-produtos">
    <?php foreach ($produtos as $produto): ?>
        <div class="card-produto">
            <img src="<?php echo $produto['imagem'] ? $produto['imagem'] : 'https://via.placeholder.com/200'; ?>" 
                 alt="<?php echo htmlspecialchars($produto['nome']); ?>">
            
            <h3><?php echo htmlspecialchars($produto['nome']); ?></h3>
            
            <p><?php echo htmlspecialchars($produto['descricao']); ?></p>
            
            <p class="preco">R$ <?php echo number_format($produto['preco'], 2, ',', '.'); ?></p>
            
            <button onclick="adicionarAoCarrinho(<?php echo $produto['id']; ?>, '<?php echo $produto['nome']; ?>', <?php echo $produto['preco']; ?>)">
                Adicionar ao Carrinho
            </button>
        </div>
    <?php endforeach; ?>
</div>

<script src="assets/js/carrinho.js"></script>

<?php require_once 'includes/footer.php'; // Traz o final do site ?>