<?php require_once "../../back_end/controle/iniciar_sessao.php" ?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Home - Administrador</title>
    <link rel="stylesheet" href="../../css/entrada_ADM.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark px-4 py-3">
        <a class="navbar-brand" href="#" style="font-size:22px; font-weight:bold;">Arquivo Cultural</a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menuNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="menuNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="cadastro/livro_cadastro.php">Cadastro de Livros</a></li>
                <li class="nav-item"><a class="nav-link" href="cadastro/filme_cadastro.php">Cadastro de Filmes</a></li>
                <li class="nav-item"><a class="nav-link btn btn-danger text-white ms-2" href="../../back_end/perfil/logout.php">Sair</a></li>
            </ul>
        </div>
    </nav>


    <h1>Bem-Vindo!</h1>
    <h2>Aqui você registra livros e filmes que quer ver ou já viu, tudo num só lugar.</h2>


    <div id="barra_comandos">
        <form action="cadastro/livro_cadastro.php"><input type="submit" value="Cadastro de Livros"></form>
        <form action="cadastro/filme_cadastro.php"><input type="submit" value="Cadastro de Filmes"></form>
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