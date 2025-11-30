<?php
require_once "../../../back_end/controle/iniciar_sessao.php";
include "../../../back_end/controle/conexao.php";

$query = "SELECT * FROM sugestaofilme WHERE Status = 'não validado'";
$result = $conn->query($query);
if (!$result) die("Erro ao buscar sugestões: " . $conn->error);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Validar Sugestões de Filmes</title>
    <style>
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #000; padding: 5px; }
        img { display: block; }
    </style>
</head>
<body>

<h1>Validar Sugestões de Filmes</h1>
<a href="../entrada_ADM.php">Home</a>

<form method="POST" action="../../../back_end/cadastro/cadastro_filme.php" enctype="multipart/form-data" id="formCadastro">
    <input type="hidden" name="sugestao_id" id="sugestao_id">

    <label>IMDb ID:</label><br>
    <input type="text" name="imdb_id" id="imdb_id" required><br>

    <label>Título:</label><br>
    <input type="text" name="titulo" id="titulo" maxlength="150" required><br>

    <label>Diretor:</label><br>
    <input type="text" name="diretor" id="diretor" maxlength="100" required><br>

    <label>Descrição:</label><br>
    <textarea name="descricao" id="descricao" rows="4" cols="50" maxlength="9999" placeholder="Digite até 9999 caracteres" required></textarea><br>

    <label>Idioma Original:</label><br>
    <input type="text" name="idioma" id="idioma" maxlength="50" required><br>

    <label>Ano de Lançamento:</label><br>
    <input type="number" name="ano_lancamento" id="ano_lancamento"><br>

    <label>Poster do filme:</label><br>
    <input type="file" name="poster" id="poster" accept="image/*"><br><br>

    <input type="submit" value="Cadastrar Filme">
</form>

<hr>

<h2>Sugestões não validadas</h2>

<?php if ($result->num_rows > 0): ?>
<table>
    <tr>
        <th>Selecionar</th>
        <th>ID</th>
        <th>IMDb ID</th>
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
            <input type="radio" name="selecionado"
                data-id="<?= $filme['ID_filme'] ?>"
                data-imdb="<?= htmlspecialchars($filme['IMDb_ID'], ENT_QUOTES) ?>"
                data-titulo="<?= htmlspecialchars($filme['Titulo'], ENT_QUOTES) ?>"
                data-diretor="<?= htmlspecialchars($filme['Diretor'], ENT_QUOTES) ?>"
                data-descricao="<?= htmlspecialchars($filme['Descricao'], ENT_QUOTES) ?>"
                data-idioma="<?= htmlspecialchars($filme['Idioma_original'], ENT_QUOTES) ?>"
                data-ano="<?= htmlspecialchars($filme['Ano_de_lancamento'], ENT_QUOTES) ?>"
            >
        </td>
        <td><?= htmlspecialchars($filme['ID_filme']) ?></td>
        <td><?= htmlspecialchars($filme['IMDb_ID']) ?></td>
        <td><?= htmlspecialchars($filme['Titulo']) ?></td>
        <td><?= htmlspecialchars($filme['Diretor']) ?></td>
        <td><?= htmlspecialchars($filme['Descricao']) ?></td>
        <td><?= htmlspecialchars($filme['Idioma_original']) ?></td>
        <td><?= htmlspecialchars($filme['Ano_de_lancamento']) ?></td>
        <td>
            <?php if ($filme['Poster'] && file_exists("../../../banco_de_dados/{$filme['Poster']}")): ?>
                <img src="../../../banco_de_dados/<?= htmlspecialchars($filme['Poster']) ?>" width="50">
            <?php else: ?>
                Sem poster
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
        document.getElementById('imdb_id').value = this.dataset.imdb;
        document.getElementById('titulo').value = this.dataset.titulo;
        document.getElementById('diretor').value = this.dataset.diretor;
        document.getElementById('descricao').value = this.dataset.descricao;
        document.getElementById('idioma').value = this.dataset.idioma;
        document.getElementById('ano_lancamento').value = this.dataset.ano;
        document.getElementById('poster').value = '';
    });
});
</script>

</body>
</html>
