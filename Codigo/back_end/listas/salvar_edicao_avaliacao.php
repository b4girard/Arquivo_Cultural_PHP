<?php
require_once "../controle/iniciar_sessao.php";
include "../controle/conexao.php";

$idAvaliacao = intval($_POST['id_avaliacao'] ?? 0);
$nota = intval($_POST['avaliacao'] ?? -1);
$comentario = $_POST['comentario'] ?? '';

if ($idAvaliacao <= 0 || $nota < 0 || $nota > 5) {
    die("Parâmetros inválidos.");
}


$stmt = $conn->prepare("
    UPDATE avaliacao 
    SET Nota = ?, Comentario = ? 
    WHERE ID_avaliacao = ? AND ID_usuario = ?
");
$stmt->bind_param("isii", $nota, $comentario, $idAvaliacao, $_SESSION['ID_usuario']);
$stmt->execute();
$stmt->close();


header("Location: ../../front_end/usuario/perfil/perfil.php?mensagem=avaliacao_atualizada");
exit;
