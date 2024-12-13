<?php 
require "db.php";
require "data.php";
// Obtém o nome do usuário vindo do POST
$usuario = $_POST['nome'] ?? null;
$query_status = "SELECT status_2 FROM participantes WHERE nome = '$usuario'";
$result_status = mysqli_query($con, $query_status);
$status = mysqli_fetch_assoc($result_status);

if ($status['status_2'] != true) {
    exit('Erro: Usuario já sorteou um nome.');
}

// Sorteia o nome
$nomeSorteado = sortearNome($con, $usuario);

// Grava o resultado no banco
gravarResultado($con, $nomeSorteado, $usuario);

// Exclui o nome do participante sorteado
excluirParticipante($con, $nomeSorteado);

usuarioJaSorteou($con, $usuario);

// Exibe o resultado
echo "O participante sorteado foi: " . $nomeSorteado;

?>