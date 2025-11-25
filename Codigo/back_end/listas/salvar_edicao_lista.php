<?php
require_once "../controle/iniciar_sessao.php";
include "../controle/conexao.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idLista = $_POST['id_lista'];
    $nome = $_POST['nome_lista'];
    $descricao = $_POST['descricao'];
    $livros = $_POST['livros'] ?? [];
    $filmes = $_POST['filmes'] ?? [];

    $stmt = $conn->prepare("UPDATE lista SET Nome_lista = ?, Descricao = ? WHERE ID_lista = ? AND ID_usuario = ?");
    $stmt->bind_param("ssii", $nome, $descricao, $idLista, $_SESSION['ID_usuario']);
    $stmt->execute();
    $stmt->close();

    $conn->query("DELETE FROM lista_midia WHERE ID_lista = $idLista");

    if ($livros) {
        $stmt = $conn->prepare("INSERT INTO lista_midia (ID_lista, ID_livro) VALUES (?, ?)");
        foreach ($livros as $idLivro) {
            $stmt->bind_param("ii", $idLista, $idLivro);
            $stmt->execute();
        }
        $stmt->close();
    }

    if ($filmes) {
        $stmt = $conn->prepare("INSERT INTO lista_midia (ID_lista, ID_filme) VALUES (?, ?)");
        foreach ($filmes as $idFilme) {
            $stmt->bind_param("ii", $idLista, $idFilme);
            $stmt->execute();
        }
        $stmt->close();
    }

    header("Location: ../../front_end/usuario/listas/listas.php");
    exit;
} else {
    header("Location: ../../front_end/usuario/listas/listas.php");
    exit;
}
?>