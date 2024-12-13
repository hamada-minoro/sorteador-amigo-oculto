document.getElementById('formSorteio').addEventListener('submit', function(event) {
  event.preventDefault();

  // Simula o sorteio e exibe a animação
  const resultElement = document.getElementById('result');
  resultElement.textContent = 'Sorteando...';

  setTimeout(function() {
      // Aqui você pode fazer a requisição AJAX para o servidor para obter o nome sorteado
      // Simulando o nome sorteado
      const nomeSorteado = "João"; // Substitua com a lógica do PHP

      resultElement.textContent = `O participante sorteado foi: ${nomeSorteado}`;
  }, 2000); // Tempo de animação de 2 segundos
});
