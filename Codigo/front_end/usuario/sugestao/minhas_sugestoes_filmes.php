<?php 
require_once "../../../back_end/controle/iniciar_sessao.php";
require_once "../../../back_end/controle/localizar_usuario.php";
include "../../../back_end/controle/conexao.php";

$userId = null;
if (isset($ID_usuario)) $userId = $ID_usuario;
if (empty($userId) && isset($idUsuario)) $userId = $idUsuario;
if (empty($userId) && isset($_SESSION['ID_usuario'])) $userId = $_SESSION['ID_usuario'];

if (empty($userId)) {
    die("Usuário não identificado. Faça login e tente novamente.");
}

$result = $conn->prepare("
    SELECT ID_filme, IMDb_ID, Titulo, Diretor, Poster, Status
    FROM sugestaofilme
    WHERE ID_usuario = ?
    ORDER BY ID_filme DESC
");
$result->bind_param("i", $userId);
$result->execute();
$result = $result->get_result();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Minhas Sugestões de Filmes</title>
    <link rel="stylesheet" href="../../../css/minhas_sugestoes_filmes.css">
</head>
<body>
    <h1>Minhas Sugestões de Filmes</h1>
    <a href="../entrada/entrada.php">Home</a>
    <p>Aqui estão listadas todas as suas sugestões de filmes enviadas.</p>

    <?php
    echo "<h2>Sugestões Enviadas</h2>";
    echo "<table border='1' cellpadding='5'>";
    echo "<tr>
            <th>ID</th>
            <th>IMDb ID</th>
            <th>Título</th>
            <th>Diretor</th>
            <th>Poster</th>
            <th>Status</th>
          </tr>";

    if ($result && $result->num_rows > 0) {

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

            echo "<td>{$row['Status']}</td>";

            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='6'>Nenhuma sugestão encontrada.</td></tr>";
    }

    echo "</table>";

    $conn->close();
    ?>

</body>
</html>
