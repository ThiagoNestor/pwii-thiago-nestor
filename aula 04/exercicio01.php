<?php

   // Dados de entrada
   $distancia_km = 350;
   $combustivel_litros = 40;
  
   // Cálculo do consumo médio
   $consumo_medio = $distancia_km / $combustivel_litros;

   // Saída do resultado
   echo "Distância percorrida" . $distancia_km . "km\n";
   echo "Combustível consumido" . $combustivel_litros . "litros\n";
   echo "Consumo médio" . number_format($consumo_medio, 2) "km\n";

?>