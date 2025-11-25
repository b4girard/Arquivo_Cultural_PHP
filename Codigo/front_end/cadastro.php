<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro</title>
    <link rel="stylesheet" href="../css/cadastro.css">
</head>

<body>
    <form action="../back_end/perfil/cadastrar_se.php" method="post">

        <label for="nome">Nome</label>
        <input required type="text" name="nome"><br><br>

        <label for="usuario">Usuário</label>
        <input required type="text" name="usuario"><br><br>

        <label for="e_mail">E-mail</label>
        <input required type="email" name="e_mail"><br><br>

        <label for="senha">Senha</label>
        <input required type="password" name="senha"><br><br>

        <br><br><a href="login.php"> Já é cadastrado?</a>


        <input type="submit" value="Cadastrar-se">
</body>

</html>