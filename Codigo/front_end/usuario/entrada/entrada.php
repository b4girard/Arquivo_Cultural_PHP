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
    <title>Home</title>

</head>

<body>
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
            <form action="../sugestao/minhas_sugestoes.php" method="post">
                <input type="submit" value="Minhas Sugestões">
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