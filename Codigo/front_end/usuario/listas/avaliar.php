<?php
require_once "../../../back_end/controle/iniciar_sessao.php";
include "../../../back_end/controle/conexao.php";

// Captura os parâmetros
$id_item = intval($_GET['id_item'] ?? $_POST['id_item'] ?? 0);
$tipo    = $_GET['tipo'] ?? $_POST['tipo'] ?? '';

if ($id_item <= 0 || !in_array($tipo, ['livro','filme'])) {
    die("Parâmetros inválidos.");
}

// Busca informações do item
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

if (!$item) die("Item não encontrado.");

// Se o formulário foi enviado
$mensagem = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['avaliacao'])) {
    $avaliacao = intval($_POST['avaliacao']);
    $comentario = $_POST['comentario'] ?? '';

    if ($avaliacao < 0 || $avaliacao > 5) {
        $mensagem = "A avaliação deve estar entre 0 e 5.";
    } else {
        // Insere na tabela avaliacao
        $stmt = $conn->prepare("
            INSERT INTO avaliacao (ID_usuario, ID_livro, ID_filme, Nota, Comentario)
            VALUES (?, ?, ?, ?, ?)
        ");

        $id_usuario = $_SESSION['ID_usuario'];
        $id_livro  = ($tipo === 'livro') ? $id_item : null;
        $id_filme  = ($tipo === 'filme') ? $id_item : null;

        $stmt->bind_param("iiiis", $id_usuario, $id_livro, $id_filme, $avaliacao, $comentario);

        if ($stmt->execute()) {
            $mensagem = "Avaliação enviada com sucesso!";
        } else {
            $mensagem = "Erro ao salvar avaliação: " . $stmt->error;
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Avaliar <?= htmlspecialchars($item['Titulo']) ?></title>
</head>
<body>
<h1><?= htmlspecialchars($item['Titulo']) ?></h1>

<?php if ($tipo === 'livro'): ?>
<p><strong>Autor:</strong> <?= htmlspecialchars($item['Autor']) ?></p>
<?php else: ?>
<p><strong>Diretor:</strong> <?= htmlspecialchars($item['Diretor']) ?></p>
<?php endif; ?>

<p><strong>Descrição:</strong> <?= htmlspecialchars($item['Descricao'] ?: 'Sem descrição disponível.') ?></p>

<?php
// Exibe capa/poster se existir
$imagem = ($tipo === 'livro') ? $item['Capa'] : $item['Poster'];
if (!empty($imagem)) {
    echo '<p><img src="../../../banco_de_dados/' . htmlspecialchars($imagem) . '" alt="Capa/Poster" width="200"></p>';
}
?>

<?php if($mensagem) echo "<p><strong>$mensagem</strong></p>"; ?>

<form method="post">
    <input type="hidden" name="id_item" value="<?= $id_item ?>">
    <input type="hidden" name="tipo" value="<?= $tipo ?>">

    <label>Avaliação (0 a 5):</label>
    <input type="number" name="avaliacao" min="0" max="5" required><br><br>

    <label>Comentário:</label><br>
    <textarea name="comentario" rows="5" cols="50"></textarea><br><br>

    <button type="submit">Enviar Avaliação</button>
</form>
</body>
</html>
