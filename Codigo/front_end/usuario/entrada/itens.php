<?php
require_once "../../../back_end/controle/iniciar_sessao.php";
include "../../../back_end/controle/conexao.php";

if (!isset($_SESSION['ID_usuario'])) {
    die("Usuário não logado. Faça login para acessar.");
}

$tipo = $_GET['tipo'] ?? '';
$id = intval($_GET['id'] ?? 0);

if ($id <= 0 || !in_array($tipo, ['livro', 'filme'])) {
    die("Item inválido.");
}

// Busca informações do item
if ($tipo === 'livro') {
    $stmt = $conn->prepare("SELECT Titulo, Autor, Descricao FROM livro WHERE ID_Livro = ?");
} else {
    $stmt = $conn->prepare("SELECT Titulo, Diretor, Descricao FROM filme WHERE ID_filme = ?");
}

$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$item = $result->fetch_assoc();
$stmt->close();

if (!$item) die("Item não encontrado.");

// Busca avaliações
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

$stmt->bind_param("i", $id);
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
<style>
    body { font-family: Arial, sans-serif; padding: 20px; }
    h1 { color: #333; }
    p { margin: 5px 0; }
    .avaliacao { border: 1px solid #ccc; padding: 10px; margin: 10px 0; border-radius: 5px; }
    .avaliacao strong { color: #0066cc; }
</style>
</head>
<body>

<a href="entrada.php">Home</a>
<h1><?= htmlspecialchars($item['Titulo']) ?></h1>

<?php if ($tipo === 'livro'): ?>
    <p><strong>Autor:</strong> <?= htmlspecialchars($item['Autor']) ?></p>
<?php else: ?>
    <p><strong>Diretor:</strong> <?= htmlspecialchars($item['Diretor']) ?></p>
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

</body>
</html>
