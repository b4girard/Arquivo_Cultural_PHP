<?php
include 'conexao.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $email = $_POST['email'];

if (isset($_POST['senha'])) {
$senha = $_POST['senha'];

$sql = "UPDATE usuario SET nome = '$nome', email = '$email' WHERE
senha = $senha";
}

if ($conn->query($sql) === TRUE) {
echo "Usuário atualizado com sucesso!";
} else {
echo "Erro: " . $conn->error;
}
}
?>


