<?php
// Valor do produto
$valor_produto = 1000;

// Cálculos
$acrescimo = 0.16; // 16%
$valor_total = $valor_produto * (1 + $acrescimo);
$parcelas = 10;
$valor_parcela = $valor_total / $parcelas;

// Saída dos resultados
echo "Valor original: R$ " . number_format($valor_produto, 2, ',', '.') . "\n";
echo "Acréscimo (16%): R$ " . number_format($valor_produto * $acrescimo, 2, ',', '.') . "\n";
echo "Valor total: R$ " . number_format($valor_total, 2, ',', '.') . "\n";
echo "Parcelas: " . $parcelas . "x de R$ " . number_format($valor_parcela, 2, ',', '.') . "\n";
?>