<?php
require_once "../../../back_end/controle/iniciar_sessao.php";
include "../../../back_end/controle/conexao.php";


if (!isset($_SESSION['ID_usuario'])) {
    die("Usuário não logado. Faça login para acessar.");
}


$tipo = $_GET['tipo'] ?? '';
$id = intval($_GET['id'] ?? 0);
$idLista = intval($_GET['id_lista'] ?? 0);

if ($id <= 0 || !in_array($tipo, ['livro', 'filme'])) {
    die("Item inválido.");
}

if ($idLista <= 0) {
    die("ID da lista inválido!");
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


if ($tipo === 'livro') {
    $stmt = $conn->prepare("SELECT Titulo, Autor, Descricao FROM livro WHERE ID_Livro = ?");
} else {
    $stmt = $conn->prepare("SELECT Titulo, Diretor, Descricao FROM filme WHERE ID_filme = ?");
}

if (!$stmt) {
    die("Erro na preparação da query: " . $conn->error);
}

$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$item = $result->fetch_assoc();

if (!$item) {
    die("Item não encontrado.");
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($item['Titulo']) ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
        }

        h1 {
            color: #333;
        }

        a {
            color: #0066cc;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        p {
            margin: 5px 0;
        }
    </style>
</head>

<body>
    <h1><?= htmlspecialchars($item['Titulo']) ?></h1>

    <?php if ($tipo === 'livro'): ?>
        <p><strong>Autor:</strong> <?= htmlspecialchars($item['Autor']) ?></p>
    <?php else: ?>
        <p><strong>Diretor:</strong> <?= htmlspecialchars($item['Diretor']) ?></p>
    <?php endif; ?>

    <p><strong>Descrição:</strong> <?= htmlspecialchars($item['Descricao'] ?: 'Sem descrição disponível.') ?></p>

    <!-- Link de voltar -->
    <p><a href="ver_lista.php?id=<?= $idLista ?>">&larr; Voltar à lista: <?= htmlspecialchars($nomeLista) ?></a></p>
</body>

</html>