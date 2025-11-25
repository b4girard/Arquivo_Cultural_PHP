<?php
require_once "../../../back_end/controle/iniciar_sessao.php";
include "../../../back_end/controle/conexao.php";


$searchLivro = trim($_GET['buscar_livro'] ?? '');
$searchFilme = trim($_GET['buscar_filme'] ?? '');


$selecionadosLivros = $_POST['livros'] ?? [];
$selecionadosFilmes = $_POST['filmes'] ?? [];
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar Lista</title>
</head>

<body>

    <h2>Criar Nova Lista</h2>

    <form method="GET" style="margin-bottom:10px;">
        <label>Buscar livro:
            <input type="text" name="buscar_livro" value="<?= htmlspecialchars($searchLivro) ?>">
        </label>
        <button type="submit">Filtrar Livros</button>
    </form>

    <form method="GET" style="margin-bottom:20px;">
        <label>Buscar filme:
            <input type="text" name="buscar_filme" value="<?= htmlspecialchars($searchFilme) ?>">
        </label>
        <button type="submit">Filtrar Filmes</button>
    </form>

    <form method="POST" action="../../../back_end/listas/salvar_lista.php">

        <label for="nome_lista">Nome da Lista</label><br>
        <input type="text" id="nome_lista" name="nome_lista" required><br><br>

        <label for="descricao">Descrição</label><br>
        <textarea id="descricao" name="descricao" rows="3"></textarea><br>
        <hr>

        <h3>Selecione Livros</h3>

        <?php

        $livrosQuery = "SELECT ID_livro, Titulo, Autor FROM livro";
        if ($searchLivro !== '') {
            $s = $conn->real_escape_string($searchLivro);
            $livrosQuery .= " WHERE Titulo LIKE '%$s%' OR Autor LIKE '%$s%'";
        }
        $livros = $conn->query($livrosQuery);
        if ($livros && $livros->num_rows > 0):
            while ($l = $livros->fetch_assoc()):
                $checked = in_array($l['ID_livro'], $selecionadosLivros) ? 'checked' : '';
                ?>
                <div>
                    <label>
                        <input type="checkbox" name="livros[]" value="<?= $l['ID_livro'] ?>" <?= $checked ?>>
                        <?= htmlspecialchars($l['Titulo']) ?> — <?= htmlspecialchars($l['Autor']) ?>
                    </label>
                </div>
                <?php
            endwhile;
        else:
            echo "<p>Nenhum livro encontrado.</p>";
        endif;
        ?>

        <hr>
        <h3>Selecione Filmes</h3>

        <?php

        $filmesQuery = "SELECT ID_filme, Titulo, Diretor FROM filme";
        if ($searchFilme !== '') {
            $s2 = $conn->real_escape_string($searchFilme);
            $filmesQuery .= " WHERE Titulo LIKE '%$s2%' OR Diretor LIKE '%$s2%'";
        }
        $filmes = $conn->query($filmesQuery);
        if ($filmes && $filmes->num_rows > 0):
            while ($f = $filmes->fetch_assoc()):
                $checkedF = in_array($f['ID_filme'], $selecionadosFilmes) ? 'checked' : '';
                ?>
                <div>
                    <label>
                        <input type="checkbox" name="filmes[]" value="<?= $f['ID_filme'] ?>" <?= $checkedF ?>>
                        <?= htmlspecialchars($f['Titulo']) ?> — <?= htmlspecialchars($f['Diretor']) ?>
                    </label>
                </div>
                <?php
            endwhile;
        else:
            echo "<p>Nenhum filme encontrado.</p>";
        endif;
        ?>

        <hr>
        <button type="submit">Salvar Lista</button>
        <a href="listas.php" style="margin-left:10px;">Cancelar</a>

    </form>

    <!-- DEBUG: verifique o que chega no POST quando clicar em Salvar -->
    <?php if ($_SERVER['REQUEST_METHOD'] === 'POST'): ?>
        <h4>DEBUG POST</h4>
        <pre><?php var_dump($_POST); ?></pre>
    <?php endif; ?>

</body>

</html>