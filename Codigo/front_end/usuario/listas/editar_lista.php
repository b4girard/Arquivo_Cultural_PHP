<?php
require_once "../../../back_end/controle/iniciar_sessao.php";
require_once "../../../back_end/controle/coenxao_lista.php";
include "../../../back_end/controle/conexao.php";

$idLista = $_GET['id'] ?? null;
if (!$idLista) {
    die("Lista inválida!");
}


$stmt = $conn->prepare("SELECT Nome_lista, Descricao FROM lista WHERE ID_lista = ? AND ID_usuario = ?");
$stmt->bind_param("ii", $idLista, $_SESSION['ID_usuario']);
$stmt->execute();
$stmt->bind_result($nomeLista, $descricao);
if (!$stmt->fetch()) {
    die("Lista não encontrada ou você não tem permissão para editar.");
}
$stmt->close();


$livrosSelecionados = [];
$res = $conn->query("SELECT ID_livro FROM lista_midia WHERE ID_lista = $idLista AND ID_livro IS NOT NULL");
if ($res) {
    while ($row = $res->fetch_assoc()) {
        $livrosSelecionados[] = (int) $row['ID_livro'];
    }
}


$livros = $conn->query("SELECT ID_livro, Titulo, Autor FROM livro");
if (!$livros) {
    die("Erro ao buscar livros: " . $conn->error);
}


$filmesSelecionados = [];
$res = $conn->query("SELECT ID_filme FROM lista_midia WHERE ID_lista = $idLista AND ID_filme IS NOT NULL");
if ($res) {
    while ($row = $res->fetch_assoc()) {
        $filmesSelecionados[] = (int) $row['ID_filme'];
    }
}


$filmes = $conn->query("SELECT ID_filme, Titulo, Diretor FROM filme");
if (!$filmes) {
    die("Erro ao buscar filmes: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Lista</title>
</head>

<body>
    <h2>Editar Lista</h2>

    <form method="POST" action="../../../back_end/listas/salvar_edicao_lista.php">
        <input type="hidden" name="id_lista" value="<?= $idLista ?>">

        <label for="nome_lista">Nome da Lista</label>
        <input type="text" id="nome_lista" name="nome_lista" value="<?= htmlspecialchars($nomeLista) ?>" required>

        <label for="descricao">Descrição</label>
        <textarea id="descricao" name="descricao" rows="3"><?= htmlspecialchars($descricao) ?></textarea>

        <hr>

        <h3>Livros</h3>
        <?php while ($l = $livros->fetch_assoc()): ?>
            <div>
                <input type="checkbox" name="livros[]" value="<?= $l['ID_livro'] ?>" <?= in_array((int) $l['ID_livro'], $livrosSelecionados) ? 'checked' : '' ?>>
                <?= htmlspecialchars($l['Titulo']) ?> — <?= htmlspecialchars($l['Autor']) ?>
            </div>
        <?php endwhile; ?>

        <hr>

        <h3>Filmes</h3>
        <?php while ($f = $filmes->fetch_assoc()): ?>
            <div>
                <input type="checkbox" name="filmes[]" value="<?= $f['ID_filme'] ?>" <?= in_array((int) $f['ID_filme'], $filmesSelecionados) ? 'checked' : '' ?>>
                <?= htmlspecialchars($f['Titulo']) ?> — <?= htmlspecialchars($f['Diretor']) ?>
            </div>
        <?php endwhile; ?>

        <hr>

        <button type="submit">Salvar Alterações</button>
        <a href="listas.php">Cancelar</a>
    </form>
</body>

</html>