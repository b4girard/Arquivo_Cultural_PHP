<?php
require_once "../../../back_end/controle/iniciar_sessao.php";
include "../../../back_end/controle/conexao.php";
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sugestão de Filmes</title>
    <link rel="stylesheet" href="../../../css/sugestao_filme.css">
</head>

<body>

<header>
    🎬 Sugestão de Filmes
</header>

<div class="container">

    <a href="../entrada/entrada.php">⬅ Voltar para Home</a>

    <form method="POST" action="../../../back_end/sugestao/sugerir_filme.php" enctype="multipart/form-data">

        <label for="imdb">IMDb ID</label>
        <input type="text" name="imdb">

        <label for="titulo">Título</label>
        <input type="text" name="titulo">

        <label for="diretor">Diretor</label>
        <input type="text" name="diretor">

        <label for="descricao">Descrição</label>
        <textarea name="descricao" rows="4" maxlength="9999" placeholder="Digite até 9999 caracteres"></textarea>

        <label for="idioma">Idioma Original</label>
        <input type="text" name="idioma">

        <label for="ano">Ano de Lançamento</label>
        <input type="number" name="ano">

        <label for="poster">Pôster</label>
        <input type="file" name="poster" accept="image/*">

        <input type="submit" value="Enviar Sugestão">

    </form>

</div>

</body>
</html>
