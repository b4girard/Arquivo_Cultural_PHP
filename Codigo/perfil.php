<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil</title>
</head>
<body>
    <H1> Seu Perfil</H1>
    <form action = "editar.php" method = "post">
            <input type="submit" value="Editar Perfil">
    </form>
    <form action = "logout.php" method = "post">
            <input type="submit" value="Logout">
    </form>

    <?php
    include "conexao.php";
    include "cadastrar_se.php";

    $dg = new phpGrid();
    $dg->set_query("SELECT Usuario, Nome_Completo, E_mail FROM usuario");
    $dg->set_query_filter("Usuario = 'usuario");
    $dg->display();

    ?>
</body>
</html>