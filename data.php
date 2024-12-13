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
}

function excluirParticipante($con, $nomeSorteado) {
    $nomeSorteadoEscapado = mysqli_real_escape_string($con, $nomeSorteado);

    $query = "UPDATE participantes SET status_1 = true WHERE nome = '$nomeSorteadoEscapado'";
    if (!mysqli_query($con, $query)) {
        exit('Erro ao excluir o participante: ' . mysqli_error($con));
    }
}

function usuarioJaSorteou($con, $usuario) {
    $query = "UPDATE participantes SET status_2 = false WHERE nome = '$usuario'";
    if (!mysqli_query($con, $query)) {
        exit('Erro ao trocar status usuario: ' . mysqli_error($con));
    }
}


?>


