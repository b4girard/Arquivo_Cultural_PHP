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
    <title>Minhas Listas</title>
        <link rel="stylesheet" href="../../../css/listas.css">
</head>

<body>
    <h1>Minhas Listas</h1>

    <a href="criar_lista.php">Criar Lista</a>
    <a href="../entrada/entrada.php">Home</a>
    <hr>

    <?php
    $sql = "SELECT * FROM lista WHERE ID_usuario = $idUsuario ORDER BY Data_criacao DESC";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<ul>";
        while ($row = $result->fetch_assoc()) {
            $idLista = $row['ID_lista'];
            $nomeLista = htmlspecialchars($row['Nome_lista']);
            $descricao = htmlspecialchars($row['Descricao']);

            echo "
            <li>
                <strong>$nomeLista</strong> - $descricao
                <a href='editar_lista.php?id=$idLista'>[Editar]</a>
                <a href='../../../back_end/listas/excluir_lista.php?id=$idLista' onclick=\"return confirm('Tem certeza que deseja excluir esta lista?')\">[Excluir]</a>
                <a href='ver_lista.php?id=$idLista'>[Ver Itens]</a>
            </li>";
        }
        echo "</ul>";
    } else {
        echo "<p>Você ainda não tem listas criadas.</p>";
    }

    $conn->close();
    ?>
</body>

</html>