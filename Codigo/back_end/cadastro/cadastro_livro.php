<?php
require_once "../controle/iniciar_sessao.php";
include "../controle/conexao.php";

// Recebe dados do formulário
$sugestao_id = $_POST['sugestao_id'] ?? null;
$isbn        = $_POST['isbn'] ?? '';
$titulo      = $_POST['titulo'] ?? '';
$autor       = $_POST['autor'] ?? '';
$descricao   = $_POST['descricao'] ?? '';
$idioma      = $_POST['idioma'] ?? '';
$editora     = $_POST['editora'] ?? '';
$n_pag       = $_POST['n_pag'] ?? null;
$capa        = $_FILES['capa'] ?? null;

// Validação básica
if (!$sugestao_id) die("Sugestão inválida.");
if (empty($isbn) || empty($titulo) || empty($autor)) die("ISBN, título e autor são obrigatórios.");
if (strlen($descricao) > 999) die("A descrição não pode ter mais de 999 caracteres.");

// ===== Buscar sugestão =====
$result = $conn->query("SELECT * FROM sugestaolivro WHERE ID_Livro = $sugestao_id");
$sugestao = $result->fetch_assoc();
if (!$sugestao) die("Sugestão não encontrada.");

// ===== Upload / mover capa =====
$capa_final = null;

// Pasta de destino
$pasta_destino = __DIR__ . "/../../banco_de_dados/imagens_livro/";
if (!is_dir($pasta_destino)) mkdir($pasta_destino, 0777, true);

// 1️⃣ Nova capa enviada pelo formulário
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

    $caminho_antigo = __DIR__ . "/../../../banco_de_dados/imagens_livro_sugestao/" . basename($sugestao['Capa']);

    if (!file_exists($caminho_antigo)) die("Arquivo da capa da sugestão não encontrado: $caminho_antigo");

    $nomeArquivo = basename($sugestao['Capa']);
    $caminho_novo = $pasta_destino . $nomeArquivo;

    // Move o arquivo para a pasta definitiva
    if (rename($caminho_antigo, $caminho_novo)) {
        $capa_final = "imagens_livro/" . $nomeArquivo;
    } else {
        die("Falha ao mover a capa da sugestão.");
    }
}


$stmt = $conn->prepare("
    INSERT INTO livro (ISBN, Titulo, Autor, Descricao, Idioma, Editora, N_Paginas, Capa)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?)
");
$stmt->bind_param(
    "ssssssis",
    $isbn, $titulo, $autor, $descricao,
    $idioma, $editora, $n_pag, $capa_final
);

if (!$stmt->execute()) {
    die("Erro ao cadastrar livro: " . $stmt->error);
}


$conn->query("UPDATE sugestaolivro SET Status = 'validado' WHERE ID_Livro = $sugestao_id");

$stmt->close();
$conn->close();

//colocar modal
echo "<p>Livro cadastrado com sucesso e sugestão validada!</p>";
echo "<a href='../../front_end/adm/entrada_ADM.php'>Voltar</a>";
?>
