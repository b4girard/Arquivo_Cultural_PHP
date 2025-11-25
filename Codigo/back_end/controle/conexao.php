<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "REGISTRADOR_FILMES_LIVROS_WEB";

$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Erro na conexão com o banco de dados: " . $conn->connect_error);
}

?>