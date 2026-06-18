<?php
// actions/calcular_frete.php

// Informa ao navegador que este arquivo retorna um JSON, e não uma página HTML
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cep'])) {
    // Remove qualquer caractere que não seja número
    $cep = preg_replace('/\D/', '', $_POST['cep']);

    if (strlen($cep) === 8) {
        // Simulando uma regra de frete por região usando o primeiro dígito do CEP
        $regiao = substr($cep, 0, 1);
        
        switch ($regiao) {
            case '0': // Grande São Paulo, por exemplo
                $taxa = 5.00;
                break;
            case '1': // Interior de SP
                $taxa = 8.50;
                break;
            case '7': // Centro-Oeste / DF
                $taxa = 12.00;
                break;
            default:   // Outras regiões
                $taxa = 15.00;
                break;
        }

        // Retorna a resposta de sucesso em formato JSON
        echo json_encode([
            'sucesso' => true,
            'valor_frete' => $taxa
        ]);
        exit;
    }
}

// Se algo der errado ou o CEP for inválido
echo json_encode([
    'sucesso' => false,
    'erro' => 'Não foi possível calcular o frete para este CEP.'
]);
exit;