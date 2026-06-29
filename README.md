### Trabalho Projeto de Pizzaria

Este foi um projeto de da faculdade no qual, nós deviamos desenvolver uma pagina web para uma pizzaria onde oobjetivo do trabalho era desenvolver Paginas Html, CSS, Javascript e ultilizar o PHP para podermos criar sessões de usuários.

# 1. Fundação e Segurança (Back-end)

Começamos pelo alicerce. Configuramos a conexão com o banco de dados PostgreSQL usando o PDO (para evitar falhas de segurança como SQL Injection) e criamos o sistema de Login e Cadastro, garantindo que as senhas fossem salvas de forma criptografada (`password_hash`).

# 2. Gerenciamento de Estado (Front-end)

Para o Carrinho de Compras, optamos por usar o JavaScript com o `localStorage` do navegador.

* **O motivo:** Isso permite que o usuário adicione e remova pizzas rapidamente sem precisar recarregar a página ou sobrecarregar o servidor do banco de dados a cada clique.

# 3. Integração Front e Back

O grande desafio era enviar as pizzas da tela para o servidor. Resolvemos isso transformando o carrinho do JavaScript em um pacote de texto (`JSON`) e colocando-o dentro de um input invisível no formulário de checkout para o PHP receber via `POST`.

# 4. Integridade de Dados

Na hora de salvar a venda, usamos o conceito de **Transação** (`beginTransaction` e `commit`).

* **O motivo:** Como um pedido exige gravar dados em duas tabelas diferentes (`pedidos` e `itens_pedido`), a transação garante que, se der erro na metade do processo, o banco de dados desfaz tudo, impedindo que exista um pedido sem itens ou itens sem pedido.

# 5. Aprimoramento com APIs (Experiência do Usuário)

Para deixar o sistema com cara de aplicação moderna, usamos o `fetch` do JavaScript para fazer requisições por debaixo dos panos (assíncronas):

Buscamos o endereço do cliente externamente (API do ViaCEP).
  
# 6. Refinamento Visual (UI/UX)

Por fim, aplicamos uma camada de CSS utilizando **Flexbox** (para alinhamentos de menus) e **CSS Grid** (para criar a vitrine responsiva de pizzas), separando completamente a lógica do sistema (PHP/JS) da aparência (CSS).

---

Esse fluxo modular é excelente porque facilita muito a manutenção. Se der um problema no visual, você vai no CSS; se o frete falhar, você vai na API; se o login quebrar, você vai no PHP. Cada peça tem sua responsabilidade clara.
