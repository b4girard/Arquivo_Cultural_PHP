<?php
require_once "../../../back_end/controle/iniciar_sessao.php";
include "../../../back_end/controle/conexao.php";
require_once "../../../back_end/controle/localizar_usuario.php";

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil</title>
    <link rel="stylesheet" href="../../../css/perfil.css">
</head>

<body>

    <div class="container">
        <h1>Seu Perfil</h1>

        <br><a href="../entrada.php">Home</a><br><br>

        <form action="editar.php" method="post">
            <button class="btn">Editar Perfil</button>
        </form>

        <form action="../../../back_end/perfil/logout.php" method="post">
            <button class="btn">Logout</button>
        </form>

        <div class="info">
            <p><strong>Usuário:</strong> <?= htmlspecialchars($usuario['Usuario']) ?></p>
            <p><strong>Nome:</strong> <?= htmlspecialchars($usuario['Nome']) ?></p>
            <p><strong>E-mail:</strong> <?= htmlspecialchars($usuario['E_mail']) ?></p>
        </div>

    </div>

</body>

</html>