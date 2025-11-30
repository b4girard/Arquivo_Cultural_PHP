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
    <title>Minhas Sugestões</title>
</head>
<body>
    <h1>Minhas Sugestões</h1>
    <a href="../entrada/entrada.php">Home</a>
    <p>Aqui estão listadas todas as suas sugestões de livros enviadas.</p>

    <?php

    $result = $conn->query("
        SELECT * 
        FROM sugestaolivro 
        WHERE ID_usuario = $ID_usuario 
        ORDER BY ID_Livro DESC
    ");

    echo "<h2>Sugestões Enviadas</h2>";
    echo "<table border='1' cellpadding='5'>";
    echo "<tr><th>ID</th><th>ISBN</th><th>Título</th><th>Autor</th><th>Capa</th><th>Status</th></tr>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>{$row['ID_Livro']}</td>";
        echo "<td>{$row['ISBN']}</td>";
        echo "<td>{$row['Titulo']}</td>";
        echo "<td>{$row['Autor']}</td>";
        echo "<td>";
        if ($row['Capa']) {

         echo '<img src="../../../banco_de_dados/' . $row['Capa'] . '" width="100">';

        } else {
            echo "Sem capa";
        }
        echo "</td>";
        echo "<td>{$row['Status']}</td>";
        echo "</tr>";
    }

    echo "</table>";
    ?>
</body>
</html>

