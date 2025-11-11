<?php

session_start();
session_unset();
session_destroy();


$_SESSION['usuario'] = "";
unset($_SESSION['usuario']);

$_SESSION['nome'] = "";
unset($_SESSION['nome']);

$_SESSION['e_mail'] = "";
unset($_SESSION['e_mail']);

$_SESSION['senha'] = "";
unset($_SESSION['senha']);

header("Location: login.php");
exit;


?>