<?php
require_once "../controle/iniciar_sessao.php";
include "../controle/conexao.php";

// Captura dados do POST
$sugestao_id    = $_POST['sugestao_id'] ?? null;
$titulo         = $_POST['titulo'] ?? '';
$diretor        = $_POST['diretor'] ?? '';
$descricao      = $_POST['descricao'] ?? '';
$idioma         = $_POST['idioma'] ?? '';
$ano_lancamento = $_POST['ano_lancamento'] ?? null;
$imdb_id        = $_POST['imdb_id'] ?? '';
$poster         = $_FILES['poster'] ?? null;

if (!$sugestao_id) die("Sugestão inválida.");
if (empty($titulo) || empty($diretor) || empty($imdb_id)) die("Título, diretor e IMDb ID são obrigatórios.");
if (strlen($descricao) > 9999) die("A descrição não pode ter mais de 9999 caracteres.");

// Busca a sugestão no banco
$stmtSug = $conn->prepare("SELECT * FROM sugestaofilme WHERE ID_filme = ?");
$stmtSug->bind_param("i", $sugestao_id);
$stmtSug->execute();
$resultSug = $stmtSug->get_result();
$sugestao = $resultSug->fetch_assoc();
$stmtSug->close();

if (!$sugestao) die("Sugestão não encontrada.");

// Pasta destino para filmes validados
$pasta_destino = "../../banco_de_dados/imagens_filme/";
if (!is_dir($pasta_destino)) mkdir($pasta_destino, 0777, true);

// Define o poster final
$poster_final = null;

if ($poster && !empty($poster['name'])) {
    // Poster enviado pelo ADM
    $tipos_permitidos = ['image/jpeg', 'image/jpg', 'image/png'];
    if (!in_array($poster['type'], $tipos_permitidos)) die("Tipo de arquivo não permitido. Use JPG ou PNG.");

    $nomeArquivo = uniqid() . "_" . preg_replace("/[^a-zA-Z0-9_\.-]/", "_", basename($poster['name']));
    $caminho_novo = $pasta_destino . $nomeArquivo;

    if (move_uploaded_file($poster['tmp_name'], $caminho_novo)) {
        $poster_final = "imagens_filme/" . $nomeArquivo;
    } else {
        die("Falha ao enviar o poster do filme.");
    }

} else if (!empty($sugestao['Poster'])) {
    // Copia o poster da sugestão
    $caminho_antigo = "../../banco_de_dados/imagens_filme_sugestao/" . basename($sugestao['Poster']);
    if (!file_exists($caminho_antigo)) die("Poster da sugestão não encontrado: $caminho_antigo");

    $nomeArquivo = basename($sugestao['Poster']);
    $caminho_novo = $pasta_destino . $nomeArquivo;

    if (copy($caminho_antigo, $caminho_novo)) {
        $poster_final = "imagens_filme/" . $nomeArquivo;
    } else {
        die("Falha ao copiar o poster da sugestão.");
    }
}

// Inserir filme na tabela definitiva
$stmtFilme = $conn->prepare("
    INSERT INTO filme (IMDb_ID, Titulo, Diretor, Descricao, Idioma_original, Ano_de_lancamento, Poster)
    VALUES (?, ?, ?, ?, ?, ?, ?)
");
$stmtFilme->bind_param(
    "sssssis",
    $imdb_id, $titulo, $diretor, $descricao,
    $idioma, $ano_lancamento, $poster_final
);

if (!$stmtFilme->execute()) {
    die("Erro ao cadastrar filme: " . $stmtFilme->error);
}
$stmtFilme->close();

// Atualiza a sugestão para 'validado'
$stmtStatus = $conn->prepare("UPDATE sugestaofilme SET Status = 'validado' WHERE ID_filme = ?");
$stmtStatus->bind_param("i", $sugestao_id);
$stmtStatus->execute();
$stmtStatus->close();

$conn->close();

// Mensagem de sucesso
echo "<p>Filme cadastrado com sucesso e sugestão validada!</p>";
echo "<a href='../../front_end/adm/entrada_ADM.php'>Voltar</a>";
?>
