<?php
require_once "../../../back_end/controle/iniciar_sessao.php";
include "../../../back_end/controle/conexao.php";

$id_item = intval($_GET['id'] ?? 0);
$tipo = $_GET['tipo'] ?? '';

if ($id_item <= 0 || !in_array($tipo, ['livro', 'filme'])) {
    die("Item inválido.");
}

if ($tipo === 'livro') {
    $stmt = $conn->prepare("SELECT Titulo, Autor, Descricao, Capa FROM livro WHERE ID_Livro = ?");
} else {
    $stmt = $conn->prepare("SELECT Titulo, Diretor, Descricao, Poster FROM filme WHERE ID_filme = ?");
}

$stmt->bind_param("i", $id_item);
$stmt->execute();
$result = $stmt->get_result();
$item = $result->fetch_assoc();
$stmt->close();

if (!$item)
    die("Item não encontrado.");

if ($tipo === 'livro') {
    $stmt = $conn->prepare("
        SELECT avaliacao.Nota, avaliacao.Comentario, usuario.Nome
        FROM avaliacao
        JOIN usuario ON avaliacao.ID_usuario = usuario.ID_usuario
        WHERE avaliacao.ID_livro = ?
        ORDER BY avaliacao.Data_avaliacao DESC
    ");
} else {
    $stmt = $conn->prepare("
        SELECT avaliacao.Nota, avaliacao.Comentario, usuario.Nome
        FROM avaliacao
        JOIN usuario ON avaliacao.ID_usuario = usuario.ID_usuario
        WHERE avaliacao.ID_filme = ?
        ORDER BY avaliacao.Data_avaliacao DESC
    ");
}

$stmt->bind_param("i", $id_item);
$stmt->execute();
$resultAvaliacoes = $stmt->get_result();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($item['Titulo']) ?></title>
    <link rel="stylesheet" href="../../../css/itens.css">
</head>

<body>

    <div class="top-link">
        <a href="../entrada/entrada.php">← Home</a>
    </div>

    <h1><?= htmlspecialchars($item['Titulo']) ?></h1>

    <div class="container">
        <div class="item-info">
            <?php if ($tipo === 'livro'): ?>
                <p><strong>Autor:</strong> <?= htmlspecialchars($item['Autor']) ?></p>
            <?php else: ?>
                <p><strong>Diretor:</strong> <?= htmlspecialchars($item['Diretor']) ?></p>
            <?php endif; ?>
            <?php
            $imagem = ($tipo === 'livro') ? $item['Capa'] : $item['Poster'];
            if (!empty($imagem)) {
                echo '<img src="../../../banco_de_dados/' . htmlspecialchars($imagem) . '" class="capa">';
            }
            ?>
            <p><strong>Descrição:</strong> <?= htmlspecialchars($item['Descricao'] ?: 'Sem descrição disponível.') ?>
            </p>


        </div>

        <form action="../listas/listas.php" method="post">
            <button type="submit">Adicionar a uma lista</button>
        </form>

        <form action="../listas/avaliar.php" method="post">
            <input type="hidden" name="id_item" value="<?= $id_item ?>">
            <input type="hidden" name="tipo" value="<?= $tipo ?>">
            <button type="submit">Avalie Aqui</button>
        </form>

        <h2>Avaliações de outros usuários</h2>

        <?php if ($resultAvaliacoes->num_rows > 0): ?>
            <?php while ($av = $resultAvaliacoes->fetch_assoc()): ?>
                <div class="avaliacao">
                    <p><strong><?= htmlspecialchars($av['Nome']) ?></strong> avaliou: <?= $av['Nota'] ?>/5</p>
                    <p><?= htmlspecialchars($av['Comentario'] ?: '-') ?></p>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>Nenhuma avaliação encontrada.</p>
        <?php endif; ?>
    </div>

</body>

</html>