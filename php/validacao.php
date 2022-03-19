<?php
  $entradaCpf = isset($_POST['entradacpf']) ? $_POST['entradacpf'] : "Oi, meu chapa!";
  
  // 1. VALIDAÇÃO
  /*
    CPF hipotético: ABCDEFGHI-JK
    J e K são os "Últimos dígitos do CPF"
    O resultado da soma, 10A + 9B + 8C + 7D + 6E + 5F + 4G + 3H + 2I, é dividido por 11.
  */
  function validandoEntrada($entCpf)
  {
    // 1º TIRA A PONTUAÇÃO
    $cpfRetorno = 0;
    $cpfRetorno = preg_replace("/\.|-/", "", $entCpf);
    // 2º ANALISA SE ALGUM NÚMERO ESTÁ FALTANDO
    if (count(str_split($cpfRetorno)) != 11) {
      $cpfRetorno = "Entrada inválida, digite conforme o texto sugerido no campo.";
    }
    return $cpfRetorno;
  }

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

  $cpfResultado = validandoEntrada($entradaCpf);
  $arrayUltimosDigitosCpf = [];
  for ($i=0; $i <= 1; $i++) { 
    // Se $i for 0, então calcula-se J, senão, calcula-se K.
    $arrayUltimosDigitosCpf[$i] = calculaUltimosDigitosCpf($cpfResultado, $i);

    // FALTA COMPARAR COM OS DOIS ÚLTIMOS DÍGITOS REAIS
  }

  echo json_encode($arrayUltimosDigitosCpf);
?>
