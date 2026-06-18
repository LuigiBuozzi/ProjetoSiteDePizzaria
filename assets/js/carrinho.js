// Recupera o carrinho salvo no navegador ou cria um array vazio
let carrinho = JSON.parse(localStorage.getItem('carrinho')) || [];

// Função chamada pelo botão "Adicionar ao Carrinho" na index.php
function adicionarAoCarrinho(id, nome, preco) {
    // Verifica se a pizza já está no carrinho
    let itemExistente = carrinho.find(item => item.id === id);
    
    if (itemExistente) {
        itemExistente.quantidade++; // Se já tem, só aumenta a quantidade
    } else {
        // Se não tem, adiciona o novo produto
        carrinho.push({ id: id, nome: nome, preco: preco, quantidade: 1 });
    }
    
    // Salva de volta no navegador
    localStorage.setItem('carrinho', JSON.stringify(carrinho));
    alert(`${nome} foi adicionado ao seu carrinho!`);
}

// Função para desenhar o carrinho na tela carrinho.php
function renderizarCarrinho() {
    const container = document.getElementById('itens-carrinho');
    const totalDisplay = document.getElementById('total-carrinho');
    const inputDados = document.getElementById('dados_carrinho');

    // Se não estivermos na página do carrinho, a função para por aqui
    if (!container) return;

    container.innerHTML = '';
    let total = 0;

    if (carrinho.length === 0) {
        container.innerHTML = '<p>Seu carrinho está vazio.</p>';
    } else {
        carrinho.forEach((item, index) => {
            let subtotal = item.preco * item.quantidade;
            total += subtotal;
            
            // Cria o HTML de cada item dinamicamente
            container.innerHTML += `
                <div class="item-carrinho" style="border-bottom: 1px solid #ccc; padding: 10px 0;">
                    <strong>${item.nome}</strong> (x${item.quantidade}) 
                    - R$ ${subtotal.toFixed(2)}
                    <button onclick="removerDoCarrinho(${index})" style="margin-left: 10px; color: red;">Remover</button>
                </div>
            `;
        });
    }

    // Atualiza o valor total na tela
    totalDisplay.innerText = total.toFixed(2);
    
    // Esse é o truque: guarda o carrinho em formato de texto (JSON) num input invisível 
    // para o PHP conseguir receber via formulário quando o cliente clicar em "Finalizar"
    if (inputDados) {
        inputDados.value = JSON.stringify(carrinho);
    }
}

function removerDoCarrinho(index) {
    carrinho.splice(index, 1); // Remove 1 item a partir do índice selecionado
    localStorage.setItem('carrinho', JSON.stringify(carrinho));
    renderizarCarrinho(); // Atualiza a tela
}

// Quando a página carregar, executa a renderização
document.addEventListener('DOMContentLoaded', renderizarCarrinho);