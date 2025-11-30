<?php
require_once "../controle/iniciar_sessao.php";
include "../controle/conexao.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $senha_atual = $_POST['senha_atual'] ?? '';

    if (empty($senha_atual)) {
        die("Senha atual é obrigatória!");
    }

    $stmt = $conn->prepare("SELECT Senha, Nome, Usuario, E_mail FROM usuario WHERE ID_usuario = ?");
    $stmt->bind_param("i", $ID_usuario);
    $stmt->execute();
    $result = $stmt->get_result();
    $usuario = $result->fetch_assoc();
    $stmt->close();

    if (!$usuario) {
        die("Usuário não encontrado!");
    }

    if (!password_verify($senha_atual, $usuario['Senha'])) {
        die("Senha atual incorreta!");
    }

    $campos = [];
    $valores = [];

    if (!empty($_POST['nome'])) {
        $campos[] = "Nome = ?";
        $valores[] = $_POST['nome'];
    }

    if (!empty($_POST['usuario'])) {
        $campos[] = "Usuario = ?";
        $valores[] = $_POST['usuario'];
    }

    if (!empty($_POST['e_mail'])) {
        $campos[] = "E_mail = ?";
        $valores[] = $_POST['e_mail'];
    }

    if (!empty($_POST['nova_senha'])) {
        $campos[] = "Senha = ?";
        $valores[] = password_hash($_POST['nova_senha'], PASSWORD_DEFAULT);
    }

    if (empty($campos)) {
        die("Nenhum campo foi preenchido para atualizar.");
    }

    $sql = "UPDATE usuario SET " . implode(", ", $campos) . " WHERE ID_usuario = ?";
    $valores[] = $ID_usuario;

    $tipos = str_repeat("s", count($valores)-1) . "i"; // todos strings exceto o último que é int
    $stmt = $conn->prepare($sql);
    $stmt->bind_param($tipos, ...$valores);

    if ($stmt->execute()) {
        header("Location: ../../../front_end/usuario/perfil/perfil.php?success=1");
    } else {
        echo "Erro ao atualizar: " . $stmt->error;
    }

    $stmt->close();
}
?>
