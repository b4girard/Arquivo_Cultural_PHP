<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sugestão de Livros</title>
        <link rel="stylesheet" href="../../../css/sugestao_livro.css">
    
</head>

<body>

<header>
    <h1>Sugestão de Livros</h1>
</header>

<div class="container">
    <a href="../entrada/entrada.php">← Voltar para Home</a>

    <form method="POST" action="../../../back_end/sugestao/sugerir_livro.php" enctype="multipart/form-data">

        
            <label for="isbn">ISBN</label>
            <input type="text" name="isbn" required>
       
            <label for="titulo">Título</label>
            <input type="text" name="titulo" required>
        
        
            <label for="autor">Autor</label>
            <input type="text" name="autor" required>
     

        
            <label for="descricao">Descrição</label>
            <textarea name="descricao" rows="4" maxlength="9999" placeholder="Digite até 9999 caracteres"></textarea>
        

        
            <label for="idioma">Idioma</label>
            <input type="text" name="idioma">
        
            <label for="editora">Editora</label>
            <input type="text" name="editora">
       
            <label for="n_pag">Número de Páginas</label>
            <input type="number" name="n_pag" min="1">
        
            <label for="capa">Capa do Livro</label>
            <input type="file" name="capa" accept="image/*">
        

        <input type="submit" value="Enviar Sugestão">

    </form>


</body>
</html>
