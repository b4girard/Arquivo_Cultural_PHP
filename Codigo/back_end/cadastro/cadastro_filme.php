<?php
include "../controle/conexao.php";

// Recebe os dados do formulário
$imdb = $_POST['imdb'] ?? '';
$titulo = $_POST['titulo'] ?? '';
$diretor = $_POST['diretor'] ?? '';
$descricao = $_POST['descricao'] ?? '';
$idioma = $_POST['idioma'] ?? '';
$ano = $_POST['ano'] ?? '';
$sugestao_id = $_POST['sugestao_id'] ?? null;

// Validações obrigatórias
if (empty($imdb) || empty($titulo) || empty($diretor)) {
    die('IMDb, título e diretor são obrigatórios.');
}

if (strlen($descricao) > 999) {
    die("A descrição não pode ter mais de 999 caracteres.");
}

// =====================================
// UPLOAD DO POSTER
// =====================================
$poster = null;

if (!empty($_FILES['poster']['name'])) {

    // Se veio de sugestão, mover da pasta de sugestão
    if ($sugestao_id) {
        $query = $conn->prepare("SELECT Poster FROM sugestaofilme WHERE IMDb_ID = ?");
        $query->bind_param("s", $imdb);
        $query->execute();
        $res = $query->get_result();
        if ($res->num_rows > 0) {
            $row = $res->fetch_assoc();
            $caminho_antigo = $row['Poster'];
            $pasta = "../../banco de dados/imagens_filme/";
            if (!is_dir($pasta)) mkdir($pasta, 0777, true);
            $nomeArquivo = basename($caminho_antigo);
            $caminhoFinal = $pasta . $nomeArquivo;

            if (rename($caminho_antigo, $caminhoFinal)) {
                $poster = $caminhoFinal;
            }
        }
    }

    // Se não veio da sugestão ou não conseguiu mover, faz upload normal
    if (!$poster) {
        $pasta = "../../banco de dados/imagens_filme/";
        if (!is_dir($pasta)) mkdir($pasta, 0777, true);
        $nomeArquivo = uniqid() . "_" . basename($_FILES['poster']['name']);
        $caminhoFinal = $pasta . $nomeArquivo;
        if (move_uploaded_file($_FILES['poster']['tmp_name'], $caminhoFinal)) {
            $poster = $caminhoFinal;
        }
    }
}

// =====================================
// INSERIR NO BANCO
// =====================================
$sql = $conn->prepare("
    INSERT INTO filme
    (IMDb_ID, Titulo, Diretor, Descricao, Idioma_original, Ano_de_lancamento, Poster)
    VALUES (?, ?, ?, ?, ?, ?, ?)
");
$sql->bind_param("sssssis", $imdb, $titulo, $diretor, $descricao, $idioma, $ano, $poster);

$success = false;
if ($sql->execute()) {
    $success = true;

    // Apaga a sugestão da tabela, se existir
    if ($sugestao_id) {
        $del = $conn->prepare("DELETE FROM sugestaofilme WHERE IMDb_ID = ?");
        $del->bind_param("s", $imdb);
        $del->execute();
        $del->close();
    }
}

$sql->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Cadastro de Filme</title>
<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<!-- Modal -->
<div class="modal fade" id="feedbackModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header <?= $success ? 'bg-success text-white' : 'bg-danger text-white' ?>">
        <h5 class="modal-title"><?= $success ? 'Sucesso!' : 'Erro!' ?></h5>
      </div>
      <div class="modal-body">
        <?= $success ? 'Filme cadastrado com sucesso!' : 'Erro ao cadastrar filme.' ?>
      </div>
      <div class="modal-footer">
        <a href="../../front_end/adm/cadastro/filme_cadastro.php" class="btn btn-primary">Voltar</a>
      </div>
    </div>
  </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
var myModal = new bootstrap.Modal(document.getElementById('feedbackModal'));
myModal.show();
</script>

</body>
</html>
