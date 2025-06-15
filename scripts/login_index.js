// Função para abrir o modal de login
function abrirModal() {
  // Mostra o modal (altera CSS de "display: none" para "flex")
  document.getElementById("overlay").style.display = "flex";
}

// Função para fechar o modal de login
function fecharModal() {
  // Esconde novamente o modal
  document.getElementById("overlay").style.display = "none";
}
