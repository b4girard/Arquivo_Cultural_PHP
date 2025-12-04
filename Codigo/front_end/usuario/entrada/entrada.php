<?php
require_once "../../../back_end/controle/iniciar_sessao.php";
require_once "../../../back_end/controle/localizar_usuario.php";
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>

    <link rel="stylesheet" href="../../../css/entrada.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>


    <nav class="navbar navbar-expand-lg navbar-dark px-4 py-3">
        <a class="navbar-brand" href="#" style="font-size:22px; font-weight:bold;">Registrador Filmes e Livros</a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menuNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="menuNav">
            <ul class="navbar-nav ms-auto">

                <li class="nav-item"><a class="nav-link" href="../perfil/perfil.php">Perfil</a></li>
                <li class="nav-item"><a class="nav-link" href="../listas/listas.php">Minhas Listas</a></li>
                <li class="nav-item"><a class="nav-link" href="../sugestao/livro_sugestao.php">Sugerir Livro</a></li>
                <li class="nav-item"><a class="nav-link" href="../sugestao/filme_sugestao.php">Sugerir Filme</a></li>
                <li class="nav-item"><a class="nav-link" href="../sugestao/minhas_sugestoes_livros.php">Minhas Sugestões de Livros</a></li>
                <li class="nav-item"><a class="nav-link" href="../sugestao/minhas_sugestoes_filmes.php">Minhas Sugestões de Filmes</a></li>
            </ul>
        </div>
    </nav>

    
    <h1>Bem-Vindo!</h1>
    <h2>Aqui você registra livros e filmes que quer ver ou já viu, tudo num só lugar.</h2>

    
    <div id="barra_comandos">
        <form action="../perfil/perfil.php"><input type="submit" value="Perfil"></form>
        <form action="../listas/listas.php"><input type="submit" value="Minhas Listas"></form>
        <form action="../sugestao/livro_sugestao.php"><input type="submit" value="Sugerir Livro"></form>
        <form action="../sugestao/filme_sugestao.php"><input type="submit" value="Sugerir Filme"></form>
        <form action="../sugestao/minhas_sugestoes_livros.php"><input type="submit" value="Sugestões de Livros"></form>
        <form action="../sugestao/minhas_sugestoes_filmes.php"><input type="submit" value="Sugestões de Filmes"></form>
    </div>


    <div id="div_busca">
        <form action="buscar.php" method="get">
            <input type="text" name="buscar" id="txt_busca" placeholder="Buscar...">
            <img src="../../../../Imagens_HTML/Lupa.png" id="btn_Busca">
        </form>
    </div>

    
    <div class="carrossel">
        <div class="slides">

            <?php
            $capas = [
                ["https://m.media-amazon.com/images/I/71AeB1+8dZL._AC_UF1000,1000_QL80_.jpg", "Jantar Secreto"],
                ["https://m.media-amazon.com/images/I/91aRbGB8IFL._UF1000,1000_QL80_.jpg", "Os Sete Maridos de Evelyn Hugo"],
                ["https://m.media-amazon.com/images/I/91r5G8RxqfL.jpg", "É Assim Que Acaba"],
                ["https://m.media-amazon.com/images/I/91u0wHU3hZL._AC_UF1000,1000_QL80_.jpg", "Castella"],
                ["https://m.media-amazon.com/images/I/91RtcWPC1OL._UF1000,1000_QL80_.jpg", "Amêndoas"],
            ];

            for ($i = 0; $i < 2; $i++) {
                foreach ($capas as $c) {
                    echo '
                    <div class="slide-item">
                        <img src="' . $c[0] . '">
                        <p>' . $c[1] . '</p>
                    </div>';
                }
            }
            ?>

        </div>
    </div>

</body>
</html>
