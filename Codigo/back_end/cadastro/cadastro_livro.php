<?php
require_once "../controle/iniciar_sessao.php";
include "../controle/conexao.php";

$sugestao_id = $_POST['sugestao_id'] ?? null;
$isbn        = $_POST['isbn'] ?? '';
$titulo      = $_POST['titulo'] ?? '';
$autor       = $_POST['autor'] ?? '';
$descricao   = $_POST['descricao'] ?? '';
$idioma      = $_POST['idioma'] ?? '';
$editora     = $_POST['editora'] ?? '';
$n_pag       = $_POST['n_pag'] ?? null;
$capa        = $_FILES['capa'] ?? null;

if (!$sugestao_id) die("Sugestão inválida.");
if (empty($isbn) || empty($titulo) || empty($autor)) die("ISBN, título e autor são obrigatórios.");
if (strlen($descricao) > 9999) die("A descrição não pode ter mais de 9999 caracteres.");

$stmtSug = $conn->prepare("SELECT * FROM sugestaolivro WHERE ID_Livro = ?");
$stmtSug->bind_param("i", $sugestao_id);
$stmtSug->execute();
$resultSug = $stmtSug->get_result();
$sugestao = $resultSug->fetch_assoc();
$stmtSug->close();

if (!$sugestao) die("Sugestão não encontrada.");

$pasta_destino = "../../banco_de_dados/imagens_livro/";
if (!is_dir($pasta_destino)) mkdir($pasta_destino, 0777, true);

$capa_final = null;

if ($capa && !empty($capa['name'])) {
    $tipos_permitidos = ['image/jpeg', 'image/jpg', 'image/png'];
    if (!in_array($capa['type'], $tipos_permitidos)) die("Tipo de arquivo não permitido. Use JPG ou PNG.");

    $nomeArquivo = uniqid() . "_" . preg_replace("/[^a-zA-Z0-9_\.-]/", "_", basename($capa['name']));
    $caminho_novo = $pasta_destino . $nomeArquivo;

    if (move_uploaded_file($capa['tmp_name'], $caminho_novo)) {
        $capa_final = "imagens_livro/" . $nomeArquivo;
    } else {
        die("Falha ao enviar a nova capa.");
    }

} else if (!empty($sugestao['Capa'])) {
    $caminho_antigo = "../../banco_de_dados/imagens_livro_sugestao/" . basename($sugestao['Capa']);
    if (!file_exists($caminho_antigo)) die("Arquivo da capa da sugestão não encontrado: $caminho_antigo");

    $nomeArquivo = basename($sugestao['Capa']);
    $caminho_novo = $pasta_destino . $nomeArquivo;

    if (copy($caminho_antigo, $caminho_novo)) {
        $capa_final = "imagens_livro/" . $nomeArquivo;
    } else {
        die("Falha ao copiar a capa da sugestão.");
    }
}

$stmtLivro = $conn->prepare("
    INSERT INTO livro (ISBN, Titulo, Autor, Descricao, Idioma, Editora, N_Paginas, Capa)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?)
");
$stmtLivro->bind_param(
    "ssssssis",
    $isbn, $titulo, $autor, $descricao,
    $idioma, $editora, $n_pag, $capa_final
);

if (!$stmtLivro->execute()) {
    die("Erro ao cadastrar livro: " . $stmtLivro->error);
}
$stmtLivro->close();

$stmtStatus = $conn->prepare("UPDATE sugestaolivro SET Status = 'validado' WHERE ID_Livro = ?");
$stmtStatus->bind_param("i", $sugestao_id);
$stmtStatus->execute();
$stmtStatus->close();

$conn->close();

echo "<p>Livro cadastrado com sucesso e sugestão validada!</p>";
echo "<a href='../../front_end/adm/entrada_ADM.php'>Voltar</a>";
?>
