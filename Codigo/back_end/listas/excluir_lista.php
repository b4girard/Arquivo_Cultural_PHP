<?php
include "../controle/conexao.php";

if (isset($_GET['id'])) {
    $idLista = $_GET['id'];

    if (!is_numeric($idLista)) {
        die("ID inválido.");
    }

    $conn->query("DELETE FROM lista_midia WHERE ID_lista = $idLista");

    $stmt = $conn->prepare("DELETE FROM lista WHERE ID_lista = ?");
    $stmt->bind_param("i", $idLista);

    if ($stmt->execute()) {
        header("Location:  ../../front_end/usuario/listas/listas.php");
        exit;
    } else {
        echo "Erro ao excluir lista: " . $conn->error;
    }

    $stmt->close();
    $conn->close();
} else {
    header("Location:  ../../front_end/usuario/listas/listas.php");
    exit;
}
?>