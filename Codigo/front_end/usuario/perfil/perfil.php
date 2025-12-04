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

    <a class="voltar" href="../entrada/entrada.php">← Voltar para Home</a>

    <div class="card">

        <h1 class="titulo">Seu Perfil</h1>

        <div class="botoes">
            <form action="editar.php" method="post">
                <button class="btn editar">Editar Perfil</button>
            </form>

            <form action="../../../back_end/perfil/logout.php" method="post">
                <button class="btn logout">Logout</button>
            </form>
        </div>

        <div class="info">
            <p><strong>Usuário:</strong> <?= htmlspecialchars($usuario['Usuario']) ?></p>
            <p><strong>Nome:</strong> <?= htmlspecialchars($usuario['Nome']) ?></p>
            <p><strong>E-mail:</strong> <?= htmlspecialchars($usuario['E_mail']) ?></p>
        </div>
    </div>

    <div class="avaliacoes">
        <h2>Minhas Avaliações</h2>

        <?php
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

        echo "<div class='box-avaliacao'>";
        echo "<h3>📚 Livros</h3>";

        if ($resultLivros->num_rows > 0) {
            while ($row = $resultLivros->fetch_assoc()) {
                echo "<div class='item'>
                        <p><strong>" . htmlspecialchars($row['Titulo']) . "</strong></p>
                        <p class='nota'>" . htmlspecialchars($row['Nota']) . " ⭐</p>
                        <p class='comentario'>" . htmlspecialchars($row['Comentario'] ?: '-') . "</p>
                    </div>";
            }
        } else {
            echo "<p class='vazio'>Você ainda não avaliou nenhum livro.</p>";
        }
        echo "</div>";
        $stmtLivros->close();

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

        echo "<div class='box-avaliacao'>";
        echo "<h3>🎬 Filmes</h3>";

        if ($resultFilmes->num_rows > 0) {
            while ($row = $resultFilmes->fetch_assoc()) {
                echo "<div class='item'>
                        <p><strong>" . htmlspecialchars($row['Titulo']) . "</strong></p>
                        <p class='nota'>" . htmlspecialchars($row['Nota']) . " ⭐</p>
                        <p class='comentario'>" . htmlspecialchars($row['Comentario'] ?: '-') . "</p>
                    </div>";
            }
        } else {
            echo "<p class='vazio'>Você ainda não avaliou nenhum filme.</p>";
        }

        echo "</div>";
        $stmtFilmes->close();
        ?>

    </div>

</div>

</body>
</html>
