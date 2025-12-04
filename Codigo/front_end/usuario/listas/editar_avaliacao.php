<?php
require_once "../../../back_end/controle/iniciar_sessao.php";
include "../../../back_end/controle/conexao.php";

$idAvaliacao = intval($_GET['id'] ?? 0);
if ($idAvaliacao <= 0) {
    die("Avaliação inválida.");
}

$stmt = $conn->prepare("
    SELECT a.Nota, a.Comentario, a.ID_livro, a.ID_filme,
           l.Titulo AS Titulo_livro, l.Autor, l.Capa,
           f.Titulo AS Titulo_filme, f.Diretor, f.Poster
    FROM avaliacao a
    LEFT JOIN livro l ON a.ID_livro = l.ID_Livro
    LEFT JOIN filme f ON a.ID_filme = f.ID_filme
    WHERE a.ID_avaliacao = ? AND a.ID_usuario = ?
");
$stmt->bind_param("ii", $idAvaliacao, $_SESSION['ID_usuario']);
$stmt->execute();
$result = $stmt->get_result();
$avaliacao = $result->fetch_assoc();
$stmt->close();

if (!$avaliacao) {
    die("Avaliação não encontrada.");
}

$tipo = $avaliacao['ID_livro'] ? 'livro' : 'filme';
$itemTitulo = $tipo === 'livro' ? $avaliacao['Titulo_livro'] : $avaliacao['Titulo_filme'];
$itemAutorDiretor = $tipo === 'livro' ? $avaliacao['Autor'] : $avaliacao['Diretor'];
$itemImagem = $tipo === 'livro' ? $avaliacao['Capa'] : $avaliacao['Poster'];
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Editar Avaliação - <?= htmlspecialchars($itemTitulo) ?></title>

</head>
<body>

<h1><?= htmlspecialchars($itemTitulo) ?></h1>
<p><strong><?= $tipo === 'livro' ? 'Autor' : 'Diretor' ?>:</strong> <?= htmlspecialchars($itemAutorDiretor) ?></p>

<?php if (!empty($itemImagem)): ?>
    <p><img src="../../../banco_de_dados/<?= htmlspecialchars($itemImagem) ?>" alt="Imagem" class="item-imagem"></p>
<?php endif; ?>

<form method="post" action="../../../back_end/listas/salvar_edicao_avaliacao.php">
    <input type="hidden" name="id_avaliacao" value="<?= $idAvaliacao ?>">
    <input type="hidden" name="tipo" value="<?= $tipo ?>">

    <label>Avaliação (0 a 5):</label>
    <input type="number" name="avaliacao" min="0" max="5" required value="<?= htmlspecialchars($avaliacao['Nota']) ?>">

    <label>Comentário:</label>
    <textarea name="comentario" rows="5"><?= htmlspecialchars($avaliacao['Comentario']) ?></textarea>

    <button type="submit">Salvar Alterações</button>
</form>

</body>
</html>
