<?php
  $entradaCpf = isset($_POST['entradacpf']) ? $_POST['entradacpf'] : "Oi, meu chapa!";
  
  // 1. VALIDAÇÃO DA ENTRADA
  function validandoEntrada($entCpf)
  {
    // 1º Tira as pontuações ".", "-"
    $cpfRetorno = 0;
    $cpfRetorno = preg_replace("/\.|-/", "", $entCpf);
    // 2º Analisa se algum número está faltando
    if (count(str_split($cpfRetorno)) != 11) {
      $cpfRetorno = "Entrada inválida, digite conforme o texto sugerido no campo.";
    }
    return $cpfRetorno;
  }

  // 2. CALCULANDO OS ÚLTIMOS DOIS DÍGITOS DO CPF
  function calculaUltimosDigitosCpf($entCpf, $opcao)
  {
    // Declaração de variáveis e escolha de J ou K
    if ($opcao == 0) {
      $cteOperacaoDiferenca = 10;
      $limiteLoopMultiplicacao = 9;
    } elseif ($opcao == 1) {
      $cteOperacaoDiferenca = 11;
      $limiteLoopMultiplicacao = 10;
    }
    $digitoRetorno = 0;
    $cteOnze = 11;
    $arrayCpf = str_split($entCpf);
    $arrayCpfMultiplicado = [];
    $somaDigitosCpf = 0;
    $restoDivisao = 0;
    $condicaoResto = false;
    
    // Multiplicação e soma dos dígitos
    for ($i=0; $i < $limiteLoopMultiplicacao; $i++) { 
      // Multiplicando pelas diferenças de 10.
      $arrayCpfMultiplicado[$i] = ($cteOperacaoDiferenca - $i) * $arrayCpf[$i];
    }
    $somaDigitosCpf = array_sum($arrayCpfMultiplicado);
    
    // Analisando o resto da divisão por onze e retornando o resultado
    $restoDivisao = $somaDigitosCpf % $cteOnze;
    $condicaoResto = $restoDivisao == 0 || $restoDivisao == 1;
    if ($condicaoResto) {
      return $digitoRetorno;
    } elseif ($restoDivisao >= 2 && $restoDivisao <= 10) {
      return $cteOnze - $restoDivisao;
    }
  }

  // 3. VALIDANDO OS RESULTADOS
  function validandoResultado($entCpf, $ultimosDigitosCpf)
  {
    $txtResultadoValidacao = "";
    $arrayCpf = str_split($entCpf);
    if ($arrayCpf[count($arrayCpf)-2] == $ultimosDigitosCpf[0] && $arrayCpf[count($arrayCpf)-1] == $ultimosDigitosCpf[1]) {
      return $resultadoValidacao = "O número de CPF digitado, $entCpf, é válido!";
    } else {
      return $resultadoValidacao = "O número de CPF digitado, $entCpf, não é válido!";
    }
  }

  // EXECUÇÃO DA APLICAÇÃO
  $valCpf = validandoEntrada($entradaCpf);
  $arrayUltimosDigitosCpf = [];
  for ($i=0; $i <= 1; $i++) { 
    // Se $i for 0, então calcula-se J, senão, calcula-se K.
    $arrayUltimosDigitosCpf[$i] = calculaUltimosDigitosCpf($valCpf, $i);
  }

  // 4. VALIDAÇÃO COM A ENTRADA E RETORNANDO O RESULTADO AO FRONT-END
  $txtResultadoValidacao = [validandoResultado($valCpf, $arrayUltimosDigitosCpf)];
  echo json_encode($txtResultadoValidacao);
?>
