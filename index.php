<?php
require 'db.php';

// Obter os participantes do banco de dados
$query_nome = 'SELECT nome FROM participantes';
$result_nome = mysqli_query($con, $query_nome);

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Amigo Oculto</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Bem-vindo ao Sorteador de Amigo Oculto</h1>
        <form action="data.php" method="POST">
            <label for="nome">Selecione seu nome:</label>
            <select name="nome" id="nome" required>
                <option value="" disabled selected>Escolha seu nome</option>
                <?php while ($usuario = mysqli_fetch_assoc($result_nome)): ?>
                    <option value="<?= htmlspecialchars($usuario['nome']) ?>"><?= htmlspecialchars($usuario['nome']) ?></option>
                <?php endwhile ?>
            </select>
            <button type="submit">Entrar</button>
            <?php if (isset($erro)): ?>
                <p class="erro"><?= htmlspecialchars($erro) ?></p>
            <?php endif; ?>
        </form>
    </div>
</body>
</html>
