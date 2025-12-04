<?php
require_once "../controle/iniciar_sessao.php";
include "../controle/conexao.php";

if (!isset($_SESSION['ID_usuario'])) {
    $sucesso = false;
    $mensagem = "Você precisa estar logado para enviar sugestões.";
} else {

    $ID_usuario = $_SESSION['ID_usuario'];

    $isbn      = $_POST['isbn'] ?? '';
    $titulo    = $_POST['titulo'] ?? '';
    $autor     = $_POST['autor'] ?? '';
    $descricao = $_POST['descricao'] ?? '';
    $idioma    = $_POST['idioma'] ?? '';
    $editora   = $_POST['editora'] ?? '';
    $n_pag     = $_POST['n_pag'] ?? null;

    if (empty($isbn) || empty($titulo) || empty($autor)) {
        $sucesso = false;
        $mensagem = "ISBN, título e autor são obrigatórios.";
    } elseif (strlen($descricao) > 9999) {
        $sucesso = false;
        $mensagem = "A descrição não pode ter mais de 9999 caracteres.";
    } else {

        $capa = null;
        if (!empty($_FILES['capa']['name'])) {
            $pasta_sugestao = "../../banco_de_dados/imagens_livro_sugestao/";
            if (!is_dir($pasta_sugestao)) mkdir($pasta_sugestao, 0777, true);

            $extensao = pathinfo($_FILES['capa']['name'], PATHINFO_EXTENSION);
            $nomeArquivo = uniqid() . "_" . pathinfo($_FILES['capa']['name'], PATHINFO_FILENAME) . "." . $extensao;
            $caminhoCompleto = $pasta_sugestao . $nomeArquivo;

            if (move_uploaded_file($_FILES['capa']['tmp_name'], $caminhoCompleto)) {
                $capa = "imagens_livro_sugestao/" . $nomeArquivo;
            } else {
                $sucesso = false;
                $mensagem = "Falha ao enviar a capa do livro.";
            }
        }

        if (!isset($sucesso)) {
            $sql = $conn->prepare("
                INSERT INTO sugestaolivro 
                (ISBN, Titulo, Autor, Descricao, Idioma, Editora, N_Paginas, Capa, ID_usuario)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
            ");

            $sql->bind_param("ssssssisi",
                $isbn, $titulo, $autor, $descricao,
                $idioma, $editora, $n_pag, $capa, $ID_usuario
            );

            $sucesso = $sql->execute();
            $mensagem = $sucesso ? "Sugestão enviada com sucesso!" : "Erro ao enviar sugestão: " . $sql->error;

            $sql->close();
        }
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<title>Envio de Sugestão</title>
<style>
.modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0,0,0,0.5);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 1000;
}

.modal {
    background: #fff;
    padding: 30px;
    border-radius: 15px;
    max-width: 400px;
    width: 90%;
    text-align: center;
    box-shadow: 0 6px 25px rgba(0,0,0,0.15);
    animation: slideDown 0.4s ease;
}

.modal h2 {
    color: #405484;
    margin-bottom: 15px;
}

.modal p {
    color: #555;
    margin-bottom: 25px;
}

.modal button {
    background: #658ec7;
    color: white;
    border: none;
    padding: 10px 20px;
    border-radius: 10px;
    cursor: pointer;
    font-weight: 600;
    transition: 0.3s;
}

.modal button:hover {
    background: #4e8ca8;
    transform: scale(1.05);
}

@keyframes slideDown {
    from {transform: translateY(-50px); opacity: 0;}
    to {transform: translateY(0); opacity: 1;}
}
</style>
</head>
<body>

<div class="modal-overlay">
    <div class="modal">
        <?php if ($sucesso): ?>
            <h2>Sucesso!</h2>
            <p><?= htmlspecialchars($mensagem) ?></p>
        <?php else: ?>
            <h2>Erro!</h2>
            <p><?= htmlspecialchars($mensagem) ?></p>
        <?php endif; ?>
    </div>
</div>

<script>
setTimeout(function() {
    window.location.href = "../../front_end/usuario/sugestao/livro_sugestao.php";
}, 2000);
</script>

</body>
</html>