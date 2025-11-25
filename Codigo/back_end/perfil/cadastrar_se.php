<?php
include "../controle/conexao.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = trim($_POST["usuario"] ?? '');
    $nome = trim($_POST["nome"] ?? '');
    $email = trim($_POST["e_mail"] ?? '');
    $senha = $_POST["senha"] ?? '';

    if (empty($usuario) || empty($nome) || empty($email) || empty($senha)) {
        die("Por favor, preencha todos os campos.");
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("E-mail inválido.");
    }

    $senhaSegura = password_hash($senha, PASSWORD_DEFAULT);

    $sql = $conn->prepare("INSERT INTO usuario (Usuario, Nome, E_mail, Senha) VALUES (?, ?, ?, ?)");
    $sql->bind_param("ssss", $usuario, $nome, $email, $senhaSegura);

    if ($sql->execute()) {
        header("Location: ../../front_end/login.php?sucesso=1");
        exit;
    } else {
        die("Erro ao cadastrar usuário. Tente novamente.");
    }

    $sql->close();
    $conn->close();
}
?>