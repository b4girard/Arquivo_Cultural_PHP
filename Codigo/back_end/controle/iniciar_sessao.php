<?php
session_start();
include "conexao.php";

if (!isset($_SESSION['ID_usuario'])) {
    header("Location: login.php");
    exit;
}

$ID_usuario = $_SESSION['ID_usuario'];
$nomeUsuario = $_SESSION['nome'];


?>
