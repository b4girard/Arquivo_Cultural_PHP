<?php
require_once "../../../back_end/controle/iniciar_sessao.php";
include "../../../back_end/controle/conexao.php";

$query = "SELECT * FROM sugestaolivro WHERE Status = 'não validado'";
$result = $conn->query($query);
if (!$result) die("Erro ao buscar sugestões: " . $conn->error);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Validar Sugestões de Livros</title>
    <link rel="stylesheet" href="../css/livro_cadastro.css">
</head>
<body>

<h1>Validar Sugestões de Livros</h1>
<a href="../entrada_ADM.php">Home</a>

<form method="POST" action="../../../back_end/cadastro/cadastro_livro.php" enctype="multipart/form-data" id="formCadastro">
    <input type="hidden" name="sugestao_id" id="sugestao_id">

    <label>ISBN:</label><br>
    <input type="text" name="isbn" id="isbn" required><br>

    <label>Título:</label><br>
    <input type="text" name="titulo" id="titulo" maxlength="150" required><br>

    <label>Autor:</label><br>
    <input type="text" name="autor" id="autor" maxlength="100" required><br>

    <label>Descrição:</label><br>
    <textarea name="descricao" id="descricao" rows="4" cols="50" maxlength="9999" placeholder="Digite até 9999 caracteres" required></textarea><br>

    <label>Idioma:</label><br>
    <input type="text" name="idioma" id="idioma" maxlength="50" required><br>

    <label>Editora:</label><br>
    <input type="text" name="editora" id="editora" maxlength="100"><br>

    <label>Número de Páginas:</label><br>
    <input type="number" name="n_pag" id="n_pag"><br>

    <label>Capa do livro:</label><br>
    <input type="file" name="capa" id="capa" accept="image/*"><br><br>

    <input type="submit" value="Cadastrar Livro">
</form>

<hr>

<h2>Sugestões não validadas</h2>

<?php if ($result->num_rows > 0): ?>
<table>
    <tr>
        <th>Selecionar</th>
        <th>ID</th>
        <th>ISBN</th>
        <th>Título</th>
        <th>Autor</th>
        <th>Descrição</th>
        <th>Idioma</th>
        <th>Editora</th>
        <th>Páginas</th>
        <th>Capa</th>
    </tr>
    <?php while ($livro = $result->fetch_assoc()): ?>
    <tr>
        <td>
            <input type="radio" name="selecionado"
                data-id="<?= $livro['ID_Livro'] ?>"
                data-isbn="<?= htmlspecialchars($livro['ISBN'], ENT_QUOTES) ?>"
                data-titulo="<?= htmlspecialchars($livro['Titulo'], ENT_QUOTES) ?>"
                data-autor="<?= htmlspecialchars($livro['Autor'], ENT_QUOTES) ?>"
                data-descricao="<?= htmlspecialchars($livro['Descricao'], ENT_QUOTES) ?>"
                data-idioma="<?= htmlspecialchars($livro['Idioma'], ENT_QUOTES) ?>"
                data-editora="<?= htmlspecialchars($livro['Editora'], ENT_QUOTES) ?>"
                data-n_pag="<?= htmlspecialchars($livro['N_Paginas'], ENT_QUOTES) ?>"
            >
        </td>
        <td><?= htmlspecialchars($livro['ID_Livro']) ?></td>
        <td><?= htmlspecialchars($livro['ISBN']) ?></td>
        <td><?= htmlspecialchars($livro['Titulo']) ?></td>
        <td><?= htmlspecialchars($livro['Autor']) ?></td>
        <td><?= htmlspecialchars($livro['Descricao']) ?></td>
        <td><?= htmlspecialchars($livro['Idioma']) ?></td>
        <td><?= htmlspecialchars($livro['Editora']) ?></td>
        <td><?= htmlspecialchars($livro['N_Paginas']) ?></td>
        <td>
            <?php if ($livro['Capa'] && file_exists("../../../banco_de_dados/{$livro['Capa']}")): ?>
                <img src="../../../banco_de_dados/<?= htmlspecialchars($livro['Capa']) ?>" width="50">
            <?php else: ?>
                Sem capa
            <?php endif; ?>
        </td>
    </tr>
    <?php endwhile; ?>
</table>
<?php else: ?>
<p>Nenhuma sugestão não validada.</p>
<?php endif; ?>

<script>
document.querySelectorAll('input[name="selecionado"]').forEach(radio => {
    radio.addEventListener('change', function() {
        document.getElementById('sugestao_id').value = this.dataset.id;
        document.getElementById('isbn').value = this.dataset.isbn;
        document.getElementById('titulo').value = this.dataset.titulo;
        document.getElementById('autor').value = this.dataset.autor;
        document.getElementById('descricao').value = this.dataset.descricao;
        document.getElementById('idioma').value = this.dataset.idioma;
        document.getElementById('editora').value = this.dataset.editora;
        document.getElementById('n_pag').value = this.dataset.n_pag;
        document.getElementById('capa').value = this.dataset.capa;
    });
});
</script>

</body>
</html>
