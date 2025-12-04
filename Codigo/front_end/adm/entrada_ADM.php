<?php require_once "../../back_end/controle/iniciar_sessao.php" ?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Home - Administrador</title>
    <link rel="stylesheet" href="../css/entrada_ADM.css">
       
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body>
    <h1>Bem-vindo!</h1>
    <h2>Area Admiistrador</h2>
    <a href="cadastro/livro_cadastro.php">Cadastrar Livros</a><br><br>
    <a href="cadastro/filme_cadastro.php">Cadastrar Filmes</a><br><br>
    <a href="../../back_end/perfil/logout.php">Sair</a>

    <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">

        <div class="carousel-indicators">
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0"
                class="active"></button>
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1"></button>
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2"></button>
        </div>


        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="../Imagens Livros/Os Sete Maridos de Evelyn Hugo.jpg" class="d-block w-100"
                    alt="Os Sete Maridos de Evelyn Hugo">
                <div class="carousel-caption d-none d-md-block">
                    <h5>Os Sete Maridos de Evelyn Hugo</h5>
                    <p>Um romance envolvente sobre fama, amor e segredos.</p>
                </div>
            </div>

            <div class="carousel-item">
                <img src="../Imagens Livros/Jantar Secreto.jpg" class="d-block w-100" alt="Jantar Secreto">
                <div class="carousel-caption d-none d-md-block">
                    <h5>Jantar Secreto</h5>
                    <p>Um suspense contemporâneo brasileiro de tirar o fôlego.</p>
                </div>
            </div>

            <div class="carousel-item">
                <img src="../Imagens Livros/OutroLivro.jpg" class="d-block w-100" alt="Outro Livro">
                <div class="carousel-caption d-none d-md-block">
                    <h5>Outro Livro</h5>
                    <p>Mais uma leitura imperdível para sua lista!</p>
                </div>
            </div>
        </div>


        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators"
            data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Anterior</span>
        </button>

        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators"
            data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Próximo</span>
        </button>
    </div>


    <div id="div_busca">
        <input type="text" id="txt_busca" placeholder="Buscar..." />
        <img src="../Imagens_HTML/Lupa.png" id="btn_Busca" alt="Buscar" />
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>