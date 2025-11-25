<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login</title>
    <link rel="stylesheet" href="../css/login.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
</head>

<body>

    <div class="card">

        <div class="logo">Login</div>

        <form action="../back_end/perfil/logar_se.php" method="post">

            <div class="input-group">
                <label for="email">E-mail</label>
                <div class="input-box">
                    <i data-lucide="mail" class="icon"></i>
                    <input type="text" name="e_mail" required>
                </div>
            </div>

            <div class="input-group">
                <label for="senha">Senha</label>
                <div class="input-box">
                    <i data-lucide="lock" class="icon"></i>
                    <input type="password" name="senha" required>
                </div>
            </div>

            <button class="btn" type="submit">Entrar</button>
        </form>

        <div class="cadastro">
            Não tem conta? <a href="cadastro.php">Cadastrar-se</a>
        </div>

    </div>

    <script>
        lucide.createIcons();
    </script>

</body>

</html>