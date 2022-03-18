const resultadoValidacao = document.querySelector("#resultado-validacao");
const form = {
  txtEntradaCpf: document.querySelector("#entrada-cpf"),
  btnValidar: document.querySelector("#btn-validar"),
}

form.btnValidar.addEventListener("click", () => {
  const xhr = new XMLHttpRequest();

  xhr.onreadystatechange = () => {
    if (xhr.readyState == 4 && xhr.status == 200) {
      resultadoValidacao.innerText = JSON.parse(xhr.responseText);
    }
  }
  
  let conteudoRequest = `entradacpf=${form.txtEntradaCpf.value}`;

  xhr.open("post", "php/validacao.php");
  xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhr.send(conteudoRequest);
});
