<?php 
require_once "../../../back_end/controle/iniciar_sessao.php";
include "../../../back_end/controle/conexao.php";

// Verifica se o usuário está logado
if (!isset($_SESSION['ID_usuario'])) {
    die("Você precisa estar logado para ver suas sugestões.");
}
$ID_usuario = $_SESSION['ID_usuario'];
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
    // Busca apenas as sugestões do usuário logado
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
            // Caminho relativo correto para a página
         echo '<img src="/registrador_filmes_e_livros_php/banco_de_dados/imagens_livro_sugestao/' . $row['Capa'] . '" width="100">';

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
C:\xampp\htdocs\registrador_filmes_e_livros_php\codigo\banco_de_dados\imagens_livro_sugestao\692500403f8cb_dias_perfeitos.jpg
C:\xampp\htdocs\registrador_filmes_e_livros_php\codigo\front_end\usuario\sugestao\minhas_sugestoes.php
C:\xampp\htdocs\registrador_filmes_e_livros_php\codigo\back_end\sugestao\sugerir_livro.php
