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
</head>

<body>
    <H1>Segestão Figlmes</H1>
<a href="../entrada/entrada.php">Home</a>

<form method="POST" action="../../../back_end/sugestao/sugerir_filme.php " enctype="multipart/form-data">

        <label for="imdb">IMDb_ID</label>
        <input type="number" name="imdb"></input><br>

        <label for="titulo">Título</label>
        <input type="text" name="titulo"></input><br>

        <label for="diretor">Dirwtor</label>
        <input type="text" name="diretor"></input><br>

        <label for="descricao">Descrição</label>
        <textarea name="descricao" rows="4" cols="50" maxlength="999" placeholder="Digite até 999 caracteres"></textarea><br>

        <label for="idioma">Idioma Original</label>
        <input type="text" name="idioma"></input><br>

        <label for="ano">Ano de Lançamento</label>
        <input type="number" name="ano"></input><br>

        <label for="poster">Poster</label>
        <input type="file" name="poster" accept="image/*">Capa do Livro</input><br>

        <input type="submit" value="Enviar Sugestão">
    </form>
</body>

 
</html>