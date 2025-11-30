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
<title>Perfil</title>
<link rel="stylesheet" href="../../../css/perfil.css">
</head>
<body>
<div class="container">
    <h1>Seu Perfil</h1>

    <br><a href="../entrada/entrada.php">Home</a><br><br>

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

    <hr>

    <h2>Minhas Avaliações</h2>

    <?php
    // Avaliações de livros
    $stmtLivros = $conn->prepare("
        SELECT l.Titulo, a.Nota, a.Comentario
        FROM avaliacao a
        JOIN livro l ON a.ID_livro = l.ID_Livro
        WHERE a.ID_usuario = ?
        ORDER BY a.Data_avaliacao DESC
    ");
    $stmtLivros->bind_param("i", $ID_usuario);
    $stmtLivros->execute();
    $resultLivros = $stmtLivros->get_result();

    if ($resultLivros->num_rows > 0) {
        echo "<h3>Livros</h3><ul>";
        while ($row = $resultLivros->fetch_assoc()) {
            echo "<li><strong>" . htmlspecialchars($row['Titulo']) . "</strong>: " 
                . htmlspecialchars($row['Nota']) . " estrelas - " 
                . htmlspecialchars($row['Comentario'] ?: '-') . "</li>";
        }
        echo "</ul>";
    } else {
        echo "<p>Você ainda não avaliou nenhum livro.</p>";
    }
    $stmtLivros->close();

    // Avaliações de filmes
    $stmtFilmes = $conn->prepare("
        SELECT f.Titulo, a.Nota, a.Comentario
        FROM avaliacao a
        JOIN filme f ON a.ID_filme = f.ID_filme
        WHERE a.ID_usuario = ?
        ORDER BY a.Data_avaliacao DESC
    ");
    $stmtFilmes->bind_param("i", $ID_usuario);
    $stmtFilmes->execute();
    $resultFilmes = $stmtFilmes->get_result();

    if ($resultFilmes->num_rows > 0) {
        echo "<h3>Filmes</h3><ul>";
        while ($row = $resultFilmes->fetch_assoc()) {
            echo "<li><strong>" . htmlspecialchars($row['Titulo']) . "</strong>: " 
                . htmlspecialchars($row['Nota']) . " estrelas - " 
                . htmlspecialchars($row['Comentario'] ?: '-') . "</li>";
        }
        echo "</ul>";
    } else {
        echo "<p>Você ainda não avaliou nenhum filme.</p>";
    }
    $stmtFilmes->close();
    ?>
</div>
</body>
</html>
