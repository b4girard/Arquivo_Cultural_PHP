<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar</title>
</head>
<body>
<form action="editar_se" method="POST">

        <label for="senha">Senha atual</label>
        <input required type = "password" name = "senha"><br><br>

        <label for="nome">Novo nome</label>
        <input required type = "text" name = "nome"><br><br>

        <label for="usuario">Novo usuário</label>
        <input required type = "text" name = "usuario"><br><br>

        <label for="e_mail">Novo e-mail</label>
        <input required type = "email" name = "e_mail"><br><br>

        <label for="senha">Nova senha</label>
        <input required type = "password" name = "senha"><br><br>

        <input type="submit" value="Editar">
</form>
</body>
</html>