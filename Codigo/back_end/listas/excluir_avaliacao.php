<?php
require_once "../controle/iniciar_sessao.php";
include "../controle/conexao.php";

$idAvaliacao = intval($_POST['ID_avaliacao'] ?? 0);

if ($idAvaliacao <= 0) {
    die("Avaliação inválida.");
}
$stmt = $conn->prepare("
    DELETE FROM avaliacao
    WHERE ID_avaliacao = ? AND ID_usuario = ?
");
$stmt->bind_param("ii", $idAvaliacao, $_SESSION['ID_usuario']);
$stmt->execute();
$stmt->close();

header("Location: ../../front_end/usuario/perfil/perfil.php?mensagem=avaliacao_excluida");
exit;
