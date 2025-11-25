<?php
require_once "../controle/iniciar_sessao.php";
include "../controle/conexao.php";

// Verifica se o usuário está logado
if (!isset($_SESSION['ID_usuario'])) {
    die("Você precisa estar logado para enviar uma sugestão.");
}
$ID_usuario = $_SESSION['ID_usuario'];

// Recebe dados do formulário
$isbn      = $_POST['isbn'] ?? '';
$titulo    = $_POST['titulo'] ?? '';
$autor     = $_POST['autor'] ?? '';
$descricao = $_POST['descricao'] ?? '';
$idioma    = $_POST['idioma'] ?? '';
$editora   = $_POST['editora'] ?? '';
$n_pag     = $_POST['n_pag'] ?? null;

// Valida campos obrigatórios
if (empty($isbn) || empty($titulo) || empty($autor)) {
    die('ISBN, título e autor são obrigatórios.');
}

// Limite de caracteres da descrição
if (strlen($descricao) > 999) {
    die("A descrição não pode ter mais de 999 caracteres.");
}

// ===== Upload da capa =====
$capa = null;

if (!empty($_FILES['capa']['name'])) {
    // Caminho absoluto da pasta de destino
    $pasta_sugestao = __DIR__ . "/../../../banco_de_dados/imagens_livro_sugestao/";

    // Cria a pasta se não existir
    if (!is_dir($pasta_sugestao)) {
        mkdir($pasta_sugestao, 0777, true);
    }

    // Pega a extensão original do arquivo
    $extensao = pathinfo($_FILES['capa']['name'], PATHINFO_EXTENSION);

    // Gera um nome único com a extensão correta
    $nomeArquivo = uniqid() . "_" . pathinfo($_FILES['capa']['name'], PATHINFO_FILENAME) . "." . $extensao;
    $caminhoCompleto = $pasta_sugestao . $nomeArquivo;

    // Move o arquivo para a pasta
    if (move_uploaded_file($_FILES['capa']['tmp_name'], $caminhoCompleto)) {
        // Caminho relativo para exibição
        $capa = "imagens_livro_sugestao/" . $nomeArquivo;
    } else {
        die("Falha ao enviar a capa do livro.");
    }
}

// ===== Inserção no banco =====
$sql = $conn->prepare("
    INSERT INTO sugestaolivro 
    (ISBN, Titulo, Autor, Descricao, Idioma, Editora, N_Paginas, Capa, ID_usuario)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
");

$sql->bind_param("ssssssisi",
    $isbn, $titulo, $autor, $descricao,
    $idioma, $editora, $n_pag, $capa, $ID_usuario
);

if ($sql->execute()) {
    echo "<p>Sugestão enviada com sucesso!</p>";
} else {
    die("Erro ao enviar sugestão: " . $sql->error);
}

$sql->close();
$conn->close();
?>
