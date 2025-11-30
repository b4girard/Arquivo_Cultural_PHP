<?php
require_once "../../../back_end/controle/iniciar_sessao.php";
require_once "../../../back_end/controle/localizar_usuario.php";
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../../css/entrada.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <title>Home</title>

    <style>
        #div_busca {
            margin-top: 80px;
            display: flex;
            justify-content: center;
            align-items: center;
        }
    </style>

</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-dark px-4 py-3"
        style="border-radius:0 0 12px 12px; background-color: #3c6eac;">
        <a class="navbar-brand" href="#" style="font-size:22px; font-weight:bold;">Registrador Filmes e Livros</a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menuNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="menuNav">
            <ul class="navbar-nav ms-auto">

                <li class="nav-item">
                    <a class="nav-link" href="../perfil/perfil.php">Perfil</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../listas/listas.php">Minhas Listas</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../sugestao/livro_sugestao.php">Sugerir Livro</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../sugestao/filme_sugestao.php">Sugerir Filme</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../sugestao/minhas_sugestoes_livros.php">Minhas Sugestões de Livros</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../sugestao/minhas_sugestoes_filmes.php">Minhas Sugestões de Filmes</a>
                </li>

                <!-- Botão Sair -->
                <li class="nav-item">
                    <a class="nav-link text-danger" href="#" data-bs-toggle="modal"
                        data-bs-target="#confirmarSaidaModal">
                        Sair
                    </a>
                </li>

                <div class="modal fade" id="confirmarSaidaModal" tabindex="-1"
                    aria-labelledby="confirmarSaidaModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="confirmarSaidaModalLabel">Confirmação de Logout</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Fechar"></button>
                            </div>
                            <div class="modal-body">
                                Deseja realmente sair da sua conta?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary"
                                    data-bs-dismiss="modal">Cancelar</button>
                                <form action="../../../back_end/perfil/logout.php" method="post">
                                    <button type="submit" class="btn btn-danger">Sair</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>


            </ul>
        </div>
    </nav>
    <div class="container">
        <h1>Bem Vindo!</h1>
        <h2>Aqui você pode registrar os livros e filmes que você quer ou já assistiu, tudo num lugar só!</h2>


        <div id="barra_comandos">
            <form action="../perfil/perfil.php" method="post">
                <input type="submit" value="Perfil">
            </form>
            <form action="../listas/listas.php" method="post">
                <input type="submit" value="Minhas Listas">
            </form>
            <form action="../sugestao/livro_sugestao.php" method="post">
                <input type="submit" value="Sugerir Livro">
            </form>
            <form action="../sugestao/filme_sugestao.php" method="post">
                <input type="submit" value="Sugerir Filme">
            </form>
            <form action="../sugestao/minhas_sugestoes_livros.php" method="post">
                <input type="submit" value="Minhas Sugestões de Livros">
            </form>
            <form action="../sugestao/minhas_sugestoes_filmes.php" method="post">
                <input type="submit" value="Minhas Sugestões de Filmes">
            </form>
        </div>
    </div>

    <div id="div_busca">
        <form action="buscar.php" method="get">
            <input type="text" name="buscar" id="txt_busca" placeholder="Buscar..." />
            <img src="../../../../Imagens_HTML/Lupa.png" id="btn_Busca" alt="Buscar" />
        </form>
    </div>

    <div class="carrossel">
        <div class="slides">

            <div class="slides">

                <!-- primeira volta -->
                <div class="slide-item">
                    <img src="https://m.media-amazon.com/images/I/71AeB1+8dZL._AC_UF1000,1000_QL80_.jpg">
                    <p>Jantar Secreto</p>
                </div>

                <div class="slide-item">
                    <img src="https://m.media-amazon.com/images/I/91aRbGB8IFL._UF1000,1000_QL80_.jpg">
                    <p>Os Sete Maridos de Evelyn Hugo</p>
                </div>

                <div class="slide-item">
                    <img src="https://m.media-amazon.com/images/I/91r5G8RxqfL.jpg">
                    <p>É Assim Que Acaba</p>
                </div>

                <div class="slide-item">
                    <img src="https://m.media-amazon.com/images/I/91u0wHU3hZL._AC_UF1000,1000_QL80_.jpg">
                    <p>Castella</p>
                </div>

                <div class="slide-item">
                    <img src="https://m.media-amazon.com/images/I/91RtcWPC1OL._UF1000,1000_QL80_.jpg">
                    <p>Amêndoas</p>
                </div>

                <!-- segunda volta -->
                <div class="slide-item">
                    <a href="itens.php?tipo=livro&Titulo=Jantar Secreto"></a>
                    <img src="https://m.media-amazon.com/images/I/71AeB1+8dZL._AC_UF1000,1000_QL80_.jpg">
                    <p>Jantar Secreto</p>
                </div>

                <div class="slide-item">
                    <img src="https://m.media-amazon.com/images/I/91aRbGB8IFL._UF1000,1000_QL80_.jpg">
                    <p>Os Sete Maridos de Evelyn Hugo</p>
                </div>

                <div class="slide-item">
                    <img src="https://m.media-amazon.com/images/I/91r5G8RxqfL.jpg">
                    <p>É Assim Que Acaba</p>
                </div>

                <div class="slide-item">
                    <img src="https://m.media-amazon.com/images/I/91u0wHU3hZL._AC_UF1000,1000_QL80_.jpg">
                    <p>Castella</p>
                </div>

                <div class="slide-item">
                    <img src="https://m.media-amazon.com/images/I/91RtcWPC1OL._UF1000,1000_QL80_.jpg">
                    <p>Amêndoas</p>
                </div>

            </div>


</body>

</html>