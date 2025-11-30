<?php
require_once "../controle/iniciar_sessao.php";
include "../controle/conexao.php";

if (!isset($_SESSION['ID_usuario'])) {
    die("Você precisa estar logado para enviar sugestões.");
}
$ID_usuario = $_SESSION['ID_usuario'];


$isbn      = $_POST['isbn'] ?? '';
$titulo    = $_POST['titulo'] ?? '';
$autor     = $_POST['autor'] ?? '';
$descricao = $_POST['descricao'] ?? '';
$idioma    = $_POST['idioma'] ?? '';
$editora   = $_POST['editora'] ?? '';
$n_pag     = $_POST['n_pag'] ?? null;


if (empty($isbn) || empty($titulo) || empty($autor)) {
    die('ISBN, título e autor são obrigatórios.');
}


if (strlen($descricao) > 9999) {
    die("A descrição não pode ter mais de 9999 caracteres.");
}


$capa = null;

if (!empty($_FILES['capa']['name'])) {

    $pasta_sugestao = "../../banco_de_dados/imagens_livro_sugestao/";


    if (!is_dir($pasta_sugestao)) {
        mkdir($pasta_sugestao, 0777, true);
    }


    $extensao = pathinfo($_FILES['capa']['name'], PATHINFO_EXTENSION);


    $nomeArquivo = uniqid() . "_" . pathinfo($_FILES['capa']['name'], PATHINFO_FILENAME) . "." . $extensao;
    $caminhoCompleto = $pasta_sugestao . $nomeArquivo;


    if (move_uploaded_file($_FILES['capa']['tmp_name'], $caminhoCompleto)) {
        $capa = "imagens_livro_sugestao/" . $nomeArquivo;
    } else {
        die("Falha ao enviar a capa do livro.");
    }
}


$sql = $conn->prepare("
    INSERT INTO sugestaolivro 
    (ISBN, Titulo, Autor, Descricao, Idioma, Editora, N_Paginas, Capa, ID_usuario)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
");

$sql->bind_param("ssssssisi",
    $isbn, $titulo, $autor, $descricao,
    $idioma, $editora, $n_pag, $capa, $ID_usuario
);
//modal
if ($sql->execute()) {
    echo "<p>Sugestão enviada com sucesso!</p>";
} else {
    die("Erro ao enviar sugestão: " . $sql->error);
}

$sql->close();
$conn->close();
?>
