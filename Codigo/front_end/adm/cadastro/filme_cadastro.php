<?php
require_once "../../../back_end/controle/iniciar_sessao.php";
include "../../../back_end/controle/conexao.php";

// Buscar sugestões
$query = "SELECT * FROM sugestaofilme";
$result = $conn->query($query);
if (!$result) die("Erro ao buscar sugestões: " . $conn->error);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cadastrar Filmes</title>
</head>
<body>

<h1>Cadastrar Filmes</h1>

<a href="../entrada_ADM.php">Home</a>

<!-- Formulário principal -->
<form method="POST" action="../../../back_end/cadastro/cadastro_filme.php" enctype="multipart/form-data" id="formCadastro">
    <input type="hidden" name="sugestao_id" id="sugestao_id">

    <label>IMDb_ID:</label><br>
    <input type="number" name="imdb" id="imdb" required><br>

    <label>Título:</label><br>
    <input type="text" name="titulo" id="titulo" maxlength="150" required><br>

    <label>Diretor:</label><br>
    <input type="text" name="diretor" id="diretor" maxlength="100" required><br>

    <label>Descrição:</label><br>
    <textarea name="descricao" id="descricao" rows="4" cols="50" maxlength="999" placeholder="Digite até 999 caracteres" required></textarea><br>

    <label>Idioma Original:</label><br>
    <input type="text" name="idioma" id="idioma" maxlength="50" required><br>

    <label>Ano de Lançamento:</label><br>
    <input type="number" name="ano" id="ano"><br>

    <label>Poster:</label><br>
    <input type="file" name="poster" id="poster" accept="image/*"><br><br>

    <input type="submit" value="Cadastrar Filme">
</form>

<hr>

<h2>Sugestões já cadastradas</h2>

<?php if ($result->num_rows > 0): ?>
<table border="1" cellpadding="5">
    <tr>
        <th>Selecionar</th>
        <th>IMDb_ID</th>
        <th>Título</th>
        <th>Diretor</th>
        <th>Descrição</th>
        <th>Idioma</th>
        <th>Ano</th>
        <th>Poster</th>
    </tr>
    <?php while ($filme = $result->fetch_assoc()): ?>
    <tr>
        <td>
            <input type="checkbox" class="selecionar"
                data-id="<?= htmlspecialchars($filme['IMDb_ID']) ?>"
                data-titulo="<?= htmlspecialchars($filme['Titulo']) ?>"
                data-diretor="<?= htmlspecialchars($filme['Diretor']) ?>"
                data-descricao="<?= htmlspecialchars($filme['Descricao']) ?>"
                data-idioma="<?= htmlspecialchars($filme['Idioma_Original']) ?>"
                data-ano="<?= htmlspecialchars($filme['Ano_de_lancamento']) ?>"
            >
        </td>
        <td><?= htmlspecialchars($filme['IMDb_ID']) ?></td>
        <td><?= htmlspecialchars($filme['Titulo']) ?></td>
        <td><?= htmlspecialchars($filme['Diretor']) ?></td>
        <td><?= htmlspecialchars($filme['Descricao']) ?></td>
        <td><?= htmlspecialchars($filme['Idioma_Original']) ?></td>
        <td><?= htmlspecialchars($filme['Ano_de_lancamento']) ?></td>
        <td>
            <?php if ($filme['Poster']): ?>
                <img src="<?= htmlspecialchars($filme['Poster']) ?>" alt="Poster" width="50">
            <?php else: ?>
                Sem imagem
            <?php endif; ?>
        </td>
    </tr>
    <?php endwhile; ?>
</table>
<?php else: ?>
<p>Nenhuma sugestão cadastrada.</p>
<?php endif; ?>

<script>

document.querySelectorAll('.selecionar').forEach(radio => {
    radio.addEventListener('change', function() {
        if (this.checked) {
            document.getElementById('imdb').value = this.dataset.id;
            document.getElementById('titulo').value = this.dataset.titulo;
            document.getElementById('diretor').value = this.dataset.diretor;
            document.getElementById('descricao').value = this.dataset.descricao;
            document.getElementById('idioma').value = this.dataset.idioma;
            document.getElementById('ano').value = this.dataset.ano;
            document.getElementById('sugestao_id').value = this.dataset.id;
        }
    });
});
</script>

</body>
</html>
