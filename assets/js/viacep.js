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

                // Faz a requisição para a API do ViaCEP
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