<?php
  $entradaCpf = isset($_POST['entradacpf']) ? $_POST['entradacpf'] : "Oi, meu chapa!";
  $retorno = [$entradaCpf];
  echo json_encode($retorno);
?>
