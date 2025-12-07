<?php
session_start();
include "../controle/conexao.php";

$sucesso = false;
$mensagem = "";
$redirect = "../../front_end/login.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['e_mail'] ?? '';
    $senha = $_POST['senha'] ?? '';

    if (empty($email) || empty($senha)) {
        $sucesso = false;
        $mensagem = "Preencha todos os campos.";
        $redirect = "../../front_end/login.php";

    } else {
        $sql = $conn->prepare("SELECT ID_usuario, Nome, Senha, Tipo_usuario FROM usuario WHERE E_mail = ?");
        $sql->bind_param("s", $email);
        $sql->execute();
        $sql->bind_result($id, $nome, $hashSenha, $tipoUsuario);

        if ($sql->fetch()) {

            if (password_verify($senha, $hashSenha)) {

                $_SESSION['ID_usuario'] = $id;
                $_SESSION['nome'] = $nome;
                $_SESSION['e_mail'] = $email;
                $_SESSION['tipo_usuario'] = $tipoUsuario;

                $sucesso = true;
                $mensagem = "Login realizado com sucesso!";

                if ($tipoUsuario === 'administrador') {
                    $redirect = "../../front_end/adm/entrada_ADM.php";
                } else {
                    $redirect = "../../front_end/usuario/entrada/entrada.php";
                }

            } else {
                $sucesso = false;
                $mensagem = "Usuário ou senha incorretos.";
                $redirect = "../../front_end/login.php";
            }

        } else {
            $sucesso = false;
            $mensagem = "Usuário não cadastrado.";
            $redirect = "../../front_end/cadastro.php";
        }

        $sql->close();
    }

    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Login</title>

    <link rel="stylesheet" href="../../css/modal_entrada.css">

</head>

<body>

    <div class="modal-overlay">
        <div class="modal">
            <?php if ($sucesso): ?>
                <h2>Sucesso!</h2>
                <p><?= htmlspecialchars($mensagem) ?></p>
            <?php else: ?>
                <h2>Erro!</h2>
                <p><?= htmlspecialchars($mensagem) ?></p>
            <?php endif; ?>
        </div>
    </div>

    <script>
        setTimeout(function () {
            window.location.href = "<?= $redirect ?>";
        }, 2000);
    </script>

</body>

</html>