<?php
require_once "../../../back_end/controle/iniciar_sessao.php";
require_once "../../../back_end/controle/coenxao_lista.php";
include "../../../back_end/controle/conexao.php";


if (!isset($_SESSION['ID_usuario'])) {
    die("Usuário não logado. Faça login para acessar.");
}

$stmt = $conn->prepare("SELECT Nome_lista FROM lista WHERE ID_lista = ? AND ID_usuario = ?");
if (!$stmt) {
    die("Erro na preparação da query: " . $conn->error);
}
$stmt->bind_param("ii", $idLista, $_SESSION['ID_usuario']);
$stmt->execute();
$stmt->bind_result($nomeLista);
if (!$stmt->fetch()) {
    die("Lista não encontrada ou você não tem permissão para acessar.");
}
$stmt->close();

$query = "
    SELECT lm.ID_livro AS ID, l.Titulo, l.Autor AS Extra, 'livro' AS Tipo
    FROM lista_midia lm
    INNER JOIN livro l ON lm.ID_livro = l.ID_Livro
    WHERE lm.ID_lista = ?

    UNION ALL

    SELECT lm.ID_filme AS ID, f.Titulo, f.Diretor AS Extra, 'filme' AS Tipo
    FROM lista_midia lm
    INNER JOIN filme f ON lm.ID_filme = f.ID_filme
    WHERE lm.ID_lista = ?
";
$stmt = $conn->prepare($query);
if (!$stmt)
    die("Erro na query: " . $conn->error);

$stmt->bind_param("ii", $idLista, $idLista);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($nomeLista) ?></title>
      <link rel="stylesheet" href="../../../css/ver_lista.css">
</head>

<body>
    <h1><?= htmlspecialchars($nomeLista) ?></h1>
    <br><br><a href="listas.php">Voltar para Listas</a>

    <?php if ($result->num_rows > 0): ?>
        <?php while ($item = $result->fetch_assoc()): ?>
            <div class="item">
                <a href="itens.php?tipo=<?= $item['Tipo'] ?>&id=<?= $item['ID'] ?>&id_lista=<?= $idLista ?>">
                    <?= htmlspecialchars($item['Titulo']) ?>
                </a>
                <br><br> — <?= htmlspecialchars($item['Extra']) ?> (<?= $item['Tipo'] ?>)
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p>Nenhum item nesta lista.</p>
    <?php endif; ?>
</body>

</html>