// assets/js/viacep.js

document.addEventListener('DOMContentLoaded', function() {
    const cepInput = document.getElementById('cep');
    const enderecoInput = document.getElementById('endereco');

    // Só executa se os campos existirem na tela
    if (cepInput && enderecoInput) {
        
        // O evento 'blur' acontece quando o usuário clica fora do campo de CEP
        cepInput.addEventListener('blur', function() {
            // Remove tudo que não for número (ex: o tracinho)
            let cep = cepInput.value.replace(/\D/g, '');

            // Verifica se o CEP tem exatamente 8 números
            if (cep.length === 8) {
                // Coloca um aviso de "Buscando..." enquanto a API responde
                enderecoInput.value = "Buscando endereço...";

                // 1. Faz a requisição para a API externa do ViaCEP
                fetch(`https://viacep.com.br/ws/${cep}/json/`)
                    .then(resposta => resposta.json()) // Transforma a resposta em JSON
                    .then(dados => {
                        if (dados.erro) {
                            enderecoInput.value = '';
                            alert('CEP não encontrado. Por favor, digite manualmente.');
                        } else {
                            // Monta o endereço bonitinho e joga no campo
                            enderecoInput.value = `${dados.logradouro}, , ${dados.bairro} - ${dados.localidade}/${dados.uf}`;
                            // Foca no campo de endereço para o cliente digitar apenas o número
                            enderecoInput.focus();

                            // 2. Com o endereço preenchido, chama a nossa API interna de frete
                            calcularFreteInterno(cep);
                        }
                    })
                    .catch(erro => {
                        console.error('Erro ao buscar o CEP:', erro);
                        enderecoInput.value = '';
                        alert('Erro ao buscar o CEP. Digite o endereço manualmente.');
                    });
            }
        });
    }
});

/**
 * Envia o CEP via POST para o PHP calcular a taxa de entrega
 * @param {string} cep 
 */
function calcularFreteInterno(cep) {
    // Prepara os dados para enviar via POST (FormData)
    let dadosForm = new FormData();
    dadosForm.append('cep', cep);

    // Faz a requisição para o nosso motor PHP
    fetch('actions/calcular_frete.php', {
        method: 'POST',
        body: dadosForm
    })
    .then(res => res.json())
    .then(resposta => {
        if (resposta.sucesso) {
            const campoFrete = document.getElementById('valor-frete');
            const totalDisplay = document.getElementById('total-carrinho');

            // 1. Atualiza o valor do frete na tela
            if (campoFrete) {
                campoFrete.innerText = resposta.valor_frete.toFixed(2);
            }

            // 2. Recalcula o total geral (Produtos + Frete)
            if (totalDisplay) {
                // Pega os itens do carrinho para saber o valor real dos produtos
                let carrinho = JSON.parse(localStorage.getItem('carrinho')) || [];
                let subtotalProdutos = carrinho.reduce((total, item) => total + (item.preco * item.quantidade), 0);
                
                // Soma o subtotal das pizzas com a taxa de entrega que o PHP devolveu
                let totalGeral = subtotalProdutos + resposta.valor_frete;
                
                // Atualiza o h3 do total na tela do carrinho
                totalDisplay.innerText = totalGeral.toFixed(2);
            }
        } else {
            alert(resposta.erro);
        }
    })
    .catch(erro => {
        console.error('Erro ao calcular o frete:', erro);
    });
}