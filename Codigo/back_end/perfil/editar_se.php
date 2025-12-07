<?php
require_once "../controle/iniciar_sessao.php";
include "../controle/conexao.php";

$sucesso = false;
$mensagem = "";
$redirect = "../../front_end/usuario/perfil/perfil.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $senha_atual = $_POST['senha_atual'] ?? '';

    if (empty($senha_atual)) {
        $mensagem = "Senha atual é obrigatória!";
    } else {
        $stmt = $conn->prepare("SELECT Senha, Nome, Usuario, E_mail FROM usuario WHERE ID_usuario = ?");
        $stmt->bind_param("i", $ID_usuario);
        $stmt->execute();
        $result = $stmt->get_result();
        $usuario = $result->fetch_assoc();
        $stmt->close();

        if (!$usuario) {
            $mensagem = "Usuário não encontrado!";
        } elseif (!password_verify($senha_atual, $usuario['Senha'])) {
            $mensagem = "Senha atual incorreta!";
        } else {

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
                $mensagem = "Nenhum campo foi preenchido para atualizar.";
            } else {
                $sql = "UPDATE usuario SET " . implode(", ", $campos) . " WHERE ID_usuario = ?";
                $valores[] = $ID_usuario;
                $tipos = str_repeat("s", count($valores) - 1) . "i";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param($tipos, ...$valores);

                if ($stmt->execute()) {
                    $sucesso = true;
                    $mensagem = "Dados atualizados com sucesso!";
                } else {
                    $mensagem = "Erro ao atualizar: " . $stmt->error;
                }

                $stmt->close();
            }
        }
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Atualização de Perfil</title>
    <link rel="stylesheet" href="../../css/modal_entrada.css">
</head>

<body>

    <div class="modal-overlay" id="resultadoModal">
        <div class="modal">
            <h2><?= $sucesso ? "Sucesso!" : "Erro!" ?></h2>
            <p><?= htmlspecialchars($mensagem) ?></p>
            <button onclick="fecharModal()">OK</button>
        </div>
    </div>

    <script>
        document.getElementById('resultadoModal').style.display = 'flex';

        function fecharModal() {
            document.getElementById('resultadoModal').style.display = 'none';
            window.location.href = "<?= $redirect ?>";
        }
    </script>

</body>

</html>