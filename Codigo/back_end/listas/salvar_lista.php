<?php
require_once "../controle/iniciar_sessao.php";
include "../controle/conexao.php";


if (!isset($_SESSION['ID_usuario'])) {
    header("Location: ../../front_end/usuario/login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $idUsuario = $_SESSION['ID_usuario'];
    $nome = trim($_POST['nome_lista']);
    $descricao = trim($_POST['descricao']);
    $livros = $_POST['livros'] ?? [];
    $filmes = $_POST['filmes'] ?? [];


    $sql = $conn->prepare("INSERT INTO lista (ID_usuario, Nome_lista, Descricao) VALUES (?, ?, ?)");
    $sql->bind_param("iss", $idUsuario, $nome, $descricao);

    if (!$sql->execute()) {
        die("Erro ao criar lista: " . $conn->error);
    }


    $idLista = $conn->insert_id;


    if (!empty($livros)) {
        $sqlLivro = $conn->prepare("INSERT INTO lista_midia (ID_lista, ID_livro) VALUES (?, ?)");
        foreach ($livros as $livroID) {
            $sqlLivro->bind_param("ii", $idLista, $livroID);
            $sqlLivro->execute();
        }
        $sqlLivro->close();
    }


    if (!empty($filmes)) {
        $sqlFilme = $conn->prepare("INSERT INTO lista_midia (ID_lista, ID_filme) VALUES (?, ?)");
        foreach ($filmes as $filmeID) {
            $sqlFilme->bind_param("ii", $idLista, $filmeID);
            $sqlFilme->execute();
        }
        $sqlFilme->close();
    }

    $sql->close();
    $conn->close();


    header("Location: ../../front_end/usuario/listas/listas.php");
    exit;

} else {

    header("Location: ../../front_end/usuario/listas/listas.php");
    exit;
}
?>