<?php
require_once "../controle/iniciar_sessao.php";
include "../controle/conexao.php";

$titulo        = $_POST['titulo'] ?? '';
$diretor       = $_POST['diretor'] ?? '';
$descricao     = $_POST['descricao'] ?? '';
$idioma        = $_POST['idioma'] ?? '';
$ano_lancamento = $_POST['ano_lancamento'] ?? null;
$imdb_id       = $_POST['imdb_id'] ?? '';

if (empty($titulo) || empty($diretor) || empty($imdb_id)) {
    die('Título, diretor e IMDb ID são obrigatórios.');
}

if (strlen($descricao) > 9999) {
    die("A descrição não pode ter mais de 9999 caracteres.");
}

$poster = null;

if (!empty($_FILES['poster']['name'])) {
    $pasta_sugestao = "../../banco_de_dados/imagens_filme_sugestao/";

    if (!is_dir($pasta_sugestao)) {
        mkdir($pasta_sugestao, 0777, true);
    }

    $extensao = pathinfo($_FILES['poster']['name'], PATHINFO_EXTENSION);
    $nomeArquivo = uniqid() . "_" . pathinfo($_FILES['poster']['name'], PATHINFO_FILENAME) . "." . $extensao;
    $caminhoCompleto = $pasta_sugestao . $nomeArquivo;

    if (move_uploaded_file($_FILES['poster']['tmp_name'], $caminhoCompleto)) {
        $poster = "imagens_filme_sugestao/" . $nomeArquivo;
    } else {
        die("Falha ao enviar o poster do filme.");
    }
}

$sql = $conn->prepare("
    INSERT INTO sugestaofilme 
    (IMDb_ID, Titulo, Diretor, Descricao, Idioma_original, Ano_de_lancamento, Poster, ID_usuario)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?)
");

$sql->bind_param("sssssiis",
    $imdb_id, $titulo, $diretor, $descricao,
    $idioma, $ano_lancamento, $poster, $ID_usuario
);

if ($sql->execute()) {
    echo "<p>Sugestão de filme enviada com sucesso!</p>";
} else {
    die("Erro ao enviar sugestão: " . $sql->error);
}

$sql->close();
$conn->close();
?>
