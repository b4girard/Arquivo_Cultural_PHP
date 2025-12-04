<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= htmlspecialchars($item['Titulo']) ?></title>

<link rel="stylesheet" href="../css/item_visualizacao.css">

</head>
<body>

<div class="top-link">
    <a href="../entrada/entrada.php">Home</a>
</div>

<h1><?= htmlspecialchars($item['Titulo']) ?></h1>

<div class="container">

    <div class="item-info">

        <?php if ($tipo === 'livro'): ?>
            <p><strong>Autor:</strong> <?= htmlspecialchars($item['Autor']) ?></p>
            <?php if (!empty($item['Capa'])): ?>
                <img src="../../../banco_de_dados/<?= htmlspecialchars($item['Capa']) ?>" class="capa">
            <?php endif; ?>

        <?php else: ?>
            <p><strong>Diretor:</strong> <?= htmlspecialchars($item['Diretor']) ?></p>
            <?php if (!empty($item['Poster'])): ?>
                <img src="../../../banco_de_dados/<?= htmlspecialchars($item['Poster']) ?>" class="capa">
            <?php endif; ?>
        <?php endif; ?>

        <p><strong>Descrição:</strong> <?= htmlspecialchars($item['Descricao'] ?: 'Sem descrição disponível.') ?></p>

        <form action="../listas/listas.php" method="post">
            <button type="submit">Adicionar a uma lista</button>
        </form>

        <form action="../listas/avaliar.php" method="post">
            <input type="hidden" name="id_item" value="<?= $id ?>">
            <input type="hidden" name="tipo" value="<?= $tipo ?>">
            <button type="submit">Avalie Aqui</button>
        </form>

    </div>

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
