<?php
require_once "../../../back_end/controle/iniciar_sessao.php";
require_once "../../../back_end/controle/localizar_usuario.php";
include "../../../back_end/controle/conexao.php";

if (!isset($_SESSION['ID_usuario'])) {
    die("Você precisa estar logado para editar.");
}
$ID_usuario = $_SESSION['ID_usuario'];
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar</title>
    <link rel="stylesheet" href="../../../css/editar.css">
</head>

<body>

    <a class="voltar" href="perfil.php">← Voltar ao perfil</a>

    <form action="../../../back_end/perfil/editar_se.php" method="POST">
        <h2 class="titulo-form">Editar perfil</h2>
        <?php
        $stmt = $conn->prepare("SELECT Nome, Usuario, E_mail FROM usuario WHERE ID_usuario = ?");
        $stmt->bind_param("i", $ID_usuario);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();

            echo "<strong>Nome:</strong> " . htmlspecialchars($row['Nome']) . "<br>";
            echo "<strong>Usuário:</strong> " . htmlspecialchars($row['Usuario']) . "<br>";
            echo "<strong>Email:</strong> " . htmlspecialchars($row['E_mail']) . "<br>";
        } else {
            echo "Usuário não encontrado.";
        }
        ?>

        <label>Senha atual <span style="color:red">*</span></label>
        <input required type="password" id="senha_atual" name="senha_atual">
        <button type="button" onclick="toggleSenha('senha_atual')">👁️</button><br><br>

        <label>Nova senha</label>
        <input type="password" id="nova_senha" name="nova_senha">
        <button type="button" onclick="toggleSenha('nova_senha')">👁️</button><br><br>

        <label>Novo nome</label>
        <input type="text" name="nome"><br><br>

        <label>Novo usuário</label>
        <input type="text" name="usuario"><br><br>

        <label>Novo e-mail</label>
        <input type="email" name="e_mail"><br><br>

        <input type="submit" value="Editar">
    </form>

    <script>
        function toggleSenha(id) {
            const input = document.getElementById(id);
            if (input.type === "password") {
                input.type = "text";
            } else {
                input.type = "password";
            }
        }
    </script>
    </form>

    <br><br>


</body>

</html>