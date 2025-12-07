<?php
include "../controle/conexao.php";

$sucesso = null;
$mensagem = "";
$redirect = "../../front_end/cadastro.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = trim($_POST["usuario"] ?? '');
    $nome = trim($_POST["nome"] ?? '');
    $email = trim($_POST["e_mail"] ?? '');
    $senha = $_POST["senha"] ?? '';

    if ($usuario === '' || $nome === '' || $email === '' || $senha === '') {
        $sucesso = false;
        $mensagem = "Por favor, preencha todos os campos.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $sucesso = false;
        $mensagem = "E-mail inválido.";
    } else {
        $senhaSegura = password_hash($senha, PASSWORD_DEFAULT);

        $sql = $conn->prepare("INSERT INTO usuario (Usuario, Nome, E_mail, Senha) VALUES (?, ?, ?, ?)");
        if (!$sql) {
            $sucesso = false;
            $mensagem = "Erro no servidor, tente novamente.";
        } else {
            $sql->bind_param("ssss", $usuario, $nome, $email, $senhaSegura);
            if ($sql->execute()) {
                $sucesso = true;
                $mensagem = "Cadastro realizado com sucesso!";
                $redirect = "../../front_end/login.php?sucesso=1";
            } else {
                if (stripos($sql->error, 'duplicate') !== false) {
                    $mensagem = "Este e-mail já está em uso.";
                } else {
                    $mensagem = "Erro ao cadastrar usuário. Tente novamente.";
                }
                $sucesso = false;
            }
            $sql->close();
        }
    }
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Cadastro</title>
    <link rel="stylesheet" href="../../css/modal_entrada.css">
</head>

<body>

    <?php if ($sucesso !== null): ?>
        <div class="modal-overlay">
            <div class="modal">
                <h2><?= $sucesso ? "Sucesso!" : "Erro!" ?></h2>
                <p><?= htmlspecialchars($mensagem, ENT_QUOTES, 'UTF-8') ?></p>
                <button onclick="window.location.href='<?= htmlspecialchars($redirect, ENT_QUOTES, 'UTF-8') ?>'">OK</button>
            </div>
        </div>
        <script>
            setTimeout(function () {
                window.location.href = <?= json_encode($redirect) ?>;
            }, 2000);
        </script>
    <?php endif; ?>

</body>

</html>