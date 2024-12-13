<?php 
// Obtém o nome do usuário vindo do POST
require "db.php";
require "data.php";
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

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultado do Sorteio</title>
    <link rel="stylesheet" href="style2.css">
</head>
<body>

<div class="resultado-container">
    <h1>Resultado do Sorteio</h1>
    <p>O participante sorteado foi:</p>
    <div class="nome-sorteado">
        <?php echo $nomeSorteado; ?>
    </div>
    <br>
    <button class="btn-voltar" onclick="window.history.back()">Voltar</button>
</div>

</body>
</html>
