<?php
  $entradaCpf = isset($_POST['entradacpf']) ? $_POST['entradacpf'] : "Oi, meu chapa!";
  
  // 1. VALIDAÇÃO
  /*
    ABCDEFGHI/JK
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

  $cpfResultado = validandoEntrada($entradaCpf);
  $jsonCpfResultado = [$cpfResultado];
  echo json_encode($jsonCpfResultado);
?>
