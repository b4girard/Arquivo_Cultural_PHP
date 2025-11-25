<?php
include "../controle/conexao.php";


$imdb = $_POST['imdb'] ?? '';
$titulo = $_POST['titulo'] ?? '';
$diretor = $_POST['diretor'] ?? '';
$descricao = $_POST['descricao'] ?? '';
$idioma = $_POST['idioma'] ?? '';
$ano = $_POST['ano'] ?? '';


if (empty($imdb) || empty($titulo) || empty($diretor)) {
    die('IMDb, título e diretor são obrigatórios.');
}

if (strlen($descricao) > 999) {
    die("A descrição não pode ter mais de 999 caracteres.");
}


$poster = null;

if (!empty($_FILES['poster']['name'])) {
    $pasta = "../../banco de dados/imagens_filme_sugestao/";

    if (!is_dir($pasta)) {
        mkdir($pasta, 0777, true);
    }

    $nomeArquivo = uniqid() . "_" . basename($_FILES['poster']['name']);
    $caminhoFinal = $pasta . $nomeArquivo;

    if (move_uploaded_file($_FILES['poster']['tmp_name'], $caminhoFinal)) {
        $poster = $caminhoFinal;
    }
}


$sql = $conn->prepare("INSERT INTO sugestaofilme 
    (IMDb_ID, Titulo, Diretor, Descricao, Idioma_original, Ano_de_lancamento, Poster)
    VALUES (?, ?, ?, ?, ?, ?, ?)
");

$sql->bind_param("sssssis", $imdb, $titulo, $diretor, $descricao, $idioma, $ano, $poster);

if ($sql->execute()) {
    echo "Sugestão enviada com sucesso!";
} else {
    echo "Erro ao enviar sugestão: " . $sql->error;
}

$sql->close();
$conn->close();
?>