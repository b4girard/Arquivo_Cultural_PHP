<?php

require_once "iniciar_sessao.php";
include "conexao.php";

if (!isset($_SESSION['ID_usuario'])) {
    die("Você precisa estar logado.");
}

$idUsuario = $_SESSION['ID_usuario'];

$stmt = $conn->prepare("SELECT Usuario, Nome, E_mail FROM usuario WHERE ID_usuario = ?");
$stmt->bind_param("i", $idUsuario);
$stmt->execute();
$result = $stmt->get_result();
$usuario = $result->fetch_assoc();
$stmt->close();
$conn->close();
?>