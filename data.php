<?php

require 'db.php';

function sortearNome($con, $usuario) {
    // Ajuste a consulta para pegar participantes com status_1 = false
    $query = "SELECT * FROM participantes WHERE status_1 = false";
    $result = mysqli_query($con, $query);

    if (!$result) {
        exit('Erro ao executar a consulta: ' . mysqli_error($con));
    }

    $participantes = [];
    while ($row = mysqli_fetch_assoc($result)) {
        // Adiciona o nome à lista de participantes se não for o nome do usuário
        if ($row['nome'] !== $usuario) {
            $participantes[] = $row['nome'];
        }
    }

    if (empty($participantes)) {
        exit('Nenhum participante encontrado.');
    }

    // Sorteia um índice aleatório
    $indiceSorteado = array_rand($participantes);
    return $participantes[$indiceSorteado];
}


function gravarResultado($con, $nomeSorteado, $usuario) {
    if (empty($usuario)) {
        exit('Erro: Nome do usuário não fornecido.');
    }

    $nomeSorteadoEscapado = mysqli_real_escape_string($con, $nomeSorteado);
    $sorteadoPorEscapado = mysqli_real_escape_string($con, $usuario);

    $query = "INSERT INTO sorteados (nome_participante, sorteado_por) VALUES ('$nomeSorteadoEscapado', '$sorteadoPorEscapado')";
    if (!mysqli_query($con, $query)) {
        exit('Erro ao gravar o resultado: ' . mysqli_error($con));
    }

    echo "Resultado gravado com sucesso!<br>";
}

function excluirParticipante($con, $nomeSorteado) {
    $nomeSorteadoEscapado = mysqli_real_escape_string($con, $nomeSorteado);

    $query = "UPDATE participantes SET status_1 = true WHERE nome = '$nomeSorteadoEscapado'";
    if (!mysqli_query($con, $query)) {
        exit('Erro ao excluir o participante: ' . mysqli_error($con));
    }

    echo "Participante excluído da tabela de participantes.<br>";
}

function usuarioJaSorteou($con, $usuario) {
    $query = "UPDATE participantes SET status_2 = false WHERE nome = '$usuario'";
    if (!mysqli_query($con, $query)) {
        exit('Erro ao trocar status usuario: ' . mysqli_error($con));
    }

    echo "Usuario não podera sortear novamente.<br>";
}

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


