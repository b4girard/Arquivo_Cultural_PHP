<?php 
require_once "../../../back_end/controle/iniciar_sessao.php";
require_once "../../../back_end/controle/localizar_usuario.php";
include "../../../back_end/controle/conexao.php";

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Minhas Sugestões de Filmes</title>
</head>
<body>
    <h1>Minhas Sugestões de Filmes</h1>
    <a href="../entrada/entrada.php">Home</a>
    <p>Aqui estão listadas todas as suas sugestões de filmes enviadas.</p>

    <?php

    $result = $conn->query("
        SELECT * 
        FROM sugestaofilme 
        WHERE ID_usuario = $ID_usuario 
        ORDER BY ID_filme DESC
    ");

    echo "<h2>Sugestões Enviadas</h2>";
    echo "<table border='1' cellpadding='5'>";
    echo "<tr><th>ID</th><th>IMDb ID</th><th>Título</th><th>Diretor</th><th>Poster</th><th>Status</th></tr>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>{$row['ID_filme']}</td>";
        echo "<td>{$row['IMDb_ID']}</td>";
        echo "<td>{$row['Titulo']}</td>";
        echo "<td>{$row['Diretor']}</td>";
        echo "<td>";
        if ($row['Poster']) {
            echo '<img src="../../../banco_de_dados/' . $row['Poster'] . '" width="100">';
        } else {
            echo "Sem poster";
        }
        echo "</td>";
        echo "<td>{$row['status']}</td>";
        echo "</tr>";
    }

    echo "</table>";
    ?>
</body>
</html>
