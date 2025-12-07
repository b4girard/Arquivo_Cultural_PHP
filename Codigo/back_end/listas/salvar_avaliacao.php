<?php
require_once "../controle/iniciar_sessao.php";
include "../controle/conexao.php";

if (!isset($_SESSION['ID_usuario'])) {
    die("Usuário não logado.");
}

$id_item = intval($_POST['id_item'] ?? 0);
$tipo = $_POST['tipo'] ?? '';
$avaliacao = intval($_POST['avaliacao'] ?? -1);
$comentario = $_POST['comentario'] ?? '';

if ($id_item <= 0 || !in_array($tipo, ['livro', 'filme'])) {
    die("Parâmetros inválidos.");
}

if ($avaliacao < 0 || $avaliacao > 5) {
    die("Avaliação inválida.");
}

$id_livro = ($tipo === 'livro') ? $id_item : null;
$id_filme = ($tipo === 'filme') ? $id_item : null;

$stmt = $conn->prepare("
    INSERT INTO avaliacao (ID_usuario, ID_livro, ID_filme, Nota, Comentario)
    VALUES (?, ?, ?, ?, ?)
");
$id_usuario = $_SESSION['ID_usuario'];
$stmt->bind_param("iiiis", $id_usuario, $id_livro, $id_filme, $avaliacao, $comentario);

$sucesso = false;
if ($stmt->execute()) {
    $sucesso = true;
}
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Avaliação</title>
    <style>
        .modal {
            display: block;
            position: fixed;
            z-index: 999;
            padding-top: 200px;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.5);
        }

        .modal-content {
            background-color: #fefefe;
            margin: auto;
            padding: 20px;
            border: 1px solid #888;
            width: 300px;
            text-align: center;
            font-family: Arial, sans-serif;
        }
    </style>
</head>

<body>

    <div class="modal">
        <div class="modal-content">
            <?php if ($sucesso): ?>
                <h2>Avaliação enviada!</h2>
                <p>Sua avaliação foi registrada com sucesso.</p>
            <?php else: ?>
                <h2>Erro!</h2>
                <p>Não foi possível salvar sua avaliação.</p>
            <?php endif; ?>
        </div>
    </div>

    <script>
        setTimeout(function () {
            window.location.href = "../../front_end/usuario/perfil/perfil.php";
        }, 2000);
    </script>

</body>

</html>