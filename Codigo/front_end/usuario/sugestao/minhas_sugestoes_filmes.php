<?php
require_once "../../../back_end/controle/iniciar_sessao.php";
require_once "../../../back_end/controle/localizar_usuario.php";
include "../../../back_end/controle/conexao.php";

if (!isset($_SESSION['ID_usuario'])) {
    die("Usuário não logado. Faça login para acessar.");
}

$ID_usuario = $_SESSION['ID_usuario'];

$result = $conn->query("
    SELECT * 
    FROM sugestaofilme 
    WHERE ID_usuario = $ID_usuario 
    ORDER BY ID_filme DESC
");

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

    <h2>Sugestões Enviadas</h2>
    <table border="1" cellpadding="5">
        <tr>
            <th>ID</th>
            <th>IMDb ID</th>
            <th>Título</th>
            <th>Diretor</th>
            <th>Poster</th>
            <th>Status</th>
        </tr>
        <?php
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
        ?>
    </table>
</body>

</html>

<?php $conn->close(); ?>