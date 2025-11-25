<?php
require_once "../../../back_end/controle/iniciar_sessao.php";
include "../../../back_end/controle/conexao.php";

$termo = $_GET["buscar"] ?? '';
$termo = trim($termo);

if (!$termo) {
    die("Por favor, insira um termo de busca válido.");
}

$likeTermo = "%$termo%";

// Busca livros
$stmtLivros = $conn->prepare("SELECT ID_livro, Titulo, Autor FROM livro WHERE Titulo LIKE ? OR Autor LIKE ?");
$stmtLivros->bind_param("ss", $likeTermo, $likeTermo);
$stmtLivros->execute();
$resultLivros = $stmtLivros->get_result();

// Busca filmes
$stmtFilmes = $conn->prepare("SELECT ID_filme, Titulo, Diretor FROM filme WHERE Titulo LIKE ? OR Diretor LIKE ?");
$stmtFilmes->bind_param("ss", $likeTermo, $likeTermo);
$stmtFilmes->execute();
$resultFilmes = $stmtFilmes->get_result();
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultado da Busca</title>
</head>

<body>
    <h2>Resultado para "<?= htmlspecialchars($termo) ?>"</h2>

    <h3>Livros</h3>
    <?php if ($resultLivros->num_rows > 0): ?>
        <ul>
            <?php while ($livro = $resultLivros->fetch_assoc()): ?>
                <li><?= htmlspecialchars($livro['Titulo']) ?> — <?= htmlspecialchars($livro['Autor']) ?></li>
            <?php endwhile; ?>
        </ul>
    <?php else: ?>
        <p>Nenhum livro encontrado.</p>
    <?php endif; ?>

    <h3>Filmes</h3>
    <?php if ($resultFilmes->num_rows > 0): ?>
        <ul>
            <?php while ($filme = $resultFilmes->fetch_assoc()): ?>
                <li><?= htmlspecialchars($filme['Titulo']) ?> — <?= htmlspecialchars($filme['Diretor']) ?></li>
            <?php endwhile; ?>
        </ul>
    <?php else: ?>
        <p>Nenhum filme encontrado.</p>
    <?php endif; ?>

</body>

</html>