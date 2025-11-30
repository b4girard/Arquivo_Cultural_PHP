<?php
require_once "../../../back_end/controle/iniciar_sessao.php";
include "../../../back_end/controle/conexao.php";
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sugestão de Livros</title>
</head>

<body>

<h1>Sugestão Livros</h1>
<a href="../entrada/entrada.php">Home</a>

<form method="POST" action="../../../back_end/sugestao/sugerir_livro.php" enctype="multipart/form-data">

    <label for="isbn">ISBN</label>
    <input type="text" name="isbn"><br>

    <label for="titulo">Título</label>
    <input type="text" name="titulo"><br>

    <label for="autor">Autor</label>
    <input type="text" name="autor"><br>

    <label for="descricao">Descrição</label>
    <textarea name="descricao" rows="4" cols="50" maxlength="9999" placeholder="Digite até 9999 caracteres"></textarea><br>

    <label for="idioma">Idioma</label>
    <input type="text" name="idioma"><br>

    <label for="editora">Editora</label>
    <input type="text" name="editora"><br>

    <label for="n_pag">Número de Páginas</label>
    <input type="number" name="n_pag"><br>

    <label for="capa">Capa do Livro</label>
    <input type="file" name="capa" accept="image/*"><br>

    <input type="submit" value="Enviar Sugestão">

</form>

</body>
</html>
