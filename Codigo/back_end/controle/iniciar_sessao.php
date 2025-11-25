<?php
session_start();
include "conexao.php";

if (!isset($_SESSION['ID_usuario'])) {
    header("Location: login.php");
    exit;
}

$idUsuario = $_SESSION['ID_usuario'];
$nomeUsuario = $_SESSION['nome'];
?>