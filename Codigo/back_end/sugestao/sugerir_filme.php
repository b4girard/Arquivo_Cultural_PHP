<?php
require_once "../controle/iniciar_sessao.php";
include "../controle/conexao.php";

$ID_usuario = $_SESSION["ID_usuario"];

$titulo         = $_POST['titulo'] ?? '';
$diretor        = $_POST['diretor'] ?? '';
$descricao      = $_POST['descricao'] ?? '';
$idioma         = $_POST['idioma'] ?? '';
$ano_lancamento = $_POST['ano'] ?? null;  
$imdb_id        = $_POST['imdb'] ?? '';    

if (empty($titulo) || empty($diretor) || empty($imdb_id)) {
    $sucesso = false;
} elseif (strlen($descricao) > 9999) {
    $sucesso = false;
} else {
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
            $sucesso = false;
        }
    }

    if (!isset($sucesso)) {
        $sql = $conn->prepare("
            INSERT INTO sugestaofilme 
            (IMDb_ID, Titulo, Diretor, Descricao, Idioma_original, Ano_de_lancamento, Poster, ID_usuario)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)
        ");

        $sql->bind_param("sssssiis",
            $imdb_id, $titulo, $diretor, $descricao,
            $idioma, $ano_lancamento, $poster, $ID_usuario
        );

        $sucesso = $sql->execute();

        $sql->close();
    }
}

$conn->close();
?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<title>Sugestão de Filme</title>

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
    color: #b08be8;
    margin-bottom: 15px;
}

.modal p {
    color: #555;
    margin-bottom: 25px;
}

.modal button {
    background: #b67ebc;
    color: white;
    border: none;
    padding: 10px 20px;
    border-radius: 12px;
    cursor: pointer;
    font-weight: 600;
    transition: 0.3s;
}

.modal button:hover {
    background: #8c65c7;
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
            <p>Sua sugestão de filme foi enviada com sucesso.</p>
        <?php else: ?>
            <h2>Erro!</h2>
            <p>Não foi possível enviar sua sugestão. Verifique os dados.</p>
        <?php endif; ?>
    </div>
</div>

<script>
setTimeout(function() {
    window.location.href = "../../front_end/usuario/sugestao/filme_sugestao.php";
}, 2000);
</script>

</body>
</html>
