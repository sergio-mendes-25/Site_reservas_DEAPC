document.addEventListener("DOMContentLoaded", () => {
  const form = document.querySelector("form");

  form.addEventListener("submit", function (event) {
    console.log("Submissão iniciada"); // <-- Ajuda a depurar
    let valido = true;

    // Limpa erros anteriores
    document.querySelectorAll(".erro").forEach(div => div.textContent = "");
    document.querySelectorAll("input").forEach(input => input.classList.remove("erro-input"));

    // Nome
    const nomeInput = document.getElementById("Nome");
    const nome = nomeInput.value.trim();
    if (nome.length < 2) {
      document.getElementById("erroNome").textContent = "O nome deve ter pelo menos 2 letras.";
      nomeInput.classList.add("erro-input");
      valido = false;
    }

    // Telefone
    const telefoneInput = document.getElementById("Telefone");
    const telefone = telefoneInput.value.trim();
    if (!/^\d{9}$/.test(telefone)) {
      document.getElementById("erroTelefone").textContent = "O telefone deve ter 9 dígitos.";
      telefoneInput.classList.add("erro-input");
      valido = false;
    }

    // Data de nascimento
    const dataInput = document.getElementById("Data_nascimento");
    const data = new Date(dataInput.value);
    const hoje = new Date();
    if (!dataInput.value || isNaN(data.getTime()) || data > hoje) {
      document.getElementById("erroData").textContent = "Data inválida ou no futuro.";
      dataInput.classList.add("erro-input");
      valido = false;
    }

    // Email
    const emailInput = document.getElementById("Email");
    const email = emailInput.value.trim();
    const regexEmail = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!regexEmail.test(email)) {
      document.getElementById("erroEmail").textContent = "Email inválido.";
      emailInput.classList.add("erro-input");
      valido = false;
    }

    // Password
    const passInput = document.getElementById("Password");
    const pass = passInput.value;
    if (pass.length < 8 || !/\d/.test(pass) || !/[a-zA-Z]/.test(pass)) {
      document.getElementById("erroPassword").textContent = "Password deve ter pelo menos 8 caracteres com letras e números.";
      passInput.classList.add("erro-input");
      valido = false;
    }

    // Se não for válido, cancela o envio
    if (!valido) {
      console.log("Formulário inválido, envio cancelado");
      event.preventDefault();
    } else {
      console.log("Formulário válido, vai ser enviado");
    }
  });
});
