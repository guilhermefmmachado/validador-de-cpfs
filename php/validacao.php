<?php
  require_once "Cpf.php";

  $entradaCpf = isset($_POST['entradacpf']) ? $_POST['entradacpf'] : "Erro no envio ao servidor.";
  
  try {
    $cpf = new Cpf($entradaCpf);
  } catch (Exception $e) {
    // Erro de formatação
    echo json_encode(["O número recebido não é válido. Um cpf deve conter 11 dígitos numéricos."]);
  }

  echo json_encode([$cpf->validarCpf()]);
?>