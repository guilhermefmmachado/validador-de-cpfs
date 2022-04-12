<?php
  // Considere "p" -> Parâmetro
  // Considere xxx.xxx.xxx-yy um número hipotético de cpf para a leitura

  class Cpf{
    public $cpfRecebido;
    private $cpfFormatado;
    public $isValido;

    function __construct($cpfRecebido){
      // Trocar Esquema de URLs e validação
      $this->cpfFormatado = $this->formatarCpf($cpfRecebido);
    }

    private function formatarCpf($pCpfRecebido) {
      $resultado = preg_replace("/\.|-/", "", $pCpfRecebido);
      if (strLen($resultado) != 11) {
        throw new Exception("O número recebido não é válido. Um cpf deve conter 11 dígitos numéricos.");
      }
      return $resultado;
    }

    public function validarCpf() {
      $resultado;
      $novePrimeirosDigitos = str_split($this->cpfFormatado);
      array_pop($novePrimeirosDigitos);
      array_pop($novePrimeirosDigitos);
      $dezPrimeirosDigitos = array_push(
        $novePrimeirosDigitos, $this->calcularPrimeiroDigitoY($novePrimeirosDigitos)
      );
      $cpfValidacao = array_push(
        $dezPrimeirosDigitos, $this->calcularSegundoDigitoY($dezPrimeirosDigitos)
      );
      $cpfValidacao = join($cpfValidacao);
      $resultado = $cpfValidacao == $this->cpfFormatado ? "Cpf válido" : "Cpf inválido";
    }

    private function calcularPrimeiroDigitoY($pNovePrimeirosDigitos) {
      $multiplicador = 10;
      $listaNoveDigitosMultiplicados = [];
      $restoDivisao11 = 0;

      for ($i=0; $i < count($pNovePrimeirosDigitos) - 1; $i++) { 
        $listaNoveDigitosMultiplicados[$i] = $pNovePrimeirosDigitos[$i] * $multiplicador;
        $multiplicador--;
      }

      $restoDivisao11 = array_sum($listaNoveDigitosMultiplicados) % 11;
      $condicaoRetorno = $restoDivisao11 != 0 || $restoDivisao11 != 1;
      if ($condicaoRetorno) { return 11 - $restoDivisao11; }
      return 0;
      // Retornando inteiro em array de string!
    }

    private function calcularSegundoDigitoY($pDezPrimeirosDigitos) {
      $multiplicador = 11;
      $listaDezDigitosMultiplicados = [];
      $restoDivisao11 = 0;

      for ($i=0; $i < count($pDezPrimeirosDigitos) - 1; $i++) { 
        $listaDezDigitosMultiplicados[$i] = $pDezPrimeirosDigitos[$i] * $multiplicador;
        $multiplicador--;
      }

      $restoDivisao11 = array_sum($listaDezDigitosMultiplicados) % 11;
      $condicaoRetorno = $restoDivisao11 != 0 || $restoDivisao11 != 1;
      if ($condicaoRetorno) { return 11 - $restoDivisao11; }
      return 0;
    }
  }
?>