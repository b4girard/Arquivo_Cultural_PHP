<?php
require_once "../../../back_end/controle/iniciar_sessao.php";
require_once "../../../back_end/controle/localizar_usuario.php";
include "../../../back_end/controle/conexao.php";
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Minhas Listas</title>
    <link rel="stylesheet" href="../../../css/listas.css?v=1">
    <link rel="stylesheet" href="../../../css/modal_excluir_lista.css?v=1">
</head>

<body>
    <div class="container my-5">
        <h1 class="text-center mb-4">Minhas Listas</h1>

        <div class="text-center mb-4">
            <a href="criar_lista.php" class="btn btn-primary me-2">Criar Lista</a>
            <a href="../entrada/entrada.php" class="btn btn-secondary">Home</a>
        </div>

        <hr>

        <ul class="list-group" id="listasContainer">
            <?php
            $sql = "SELECT * FROM lista WHERE ID_usuario = $idUsuario ORDER BY Data_criacao DESC";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $idLista = $row['ID_lista'];
                    $nomeLista = htmlspecialchars($row['Nome_lista']);
                    $descricao = htmlspecialchars($row['Descricao']);

                    echo "
                    <li class='list-group-item d-flex justify-content-between align-items-center'>
                        <div>
                            <strong>$nomeLista</strong><br>
                            <small>$descricao</small>
                        </div>
                        <div>
                            <a href='editar_lista.php?id=$idLista' class='btn btn-sm btn-warning me-1'>Editar</a>
                            <button class='btn btn-sm btn-danger me-1 btn-excluir' data-id='$idLista' data-nome='$nomeLista'>Excluir</button>
                            <a href='ver_lista.php?id=$idLista' class='btn btn-sm btn-info'>Ver Itens</a>
                        </div>
                    </li>";
                }
            } else {
                echo "<p class='text-center mt-4'>Você ainda não tem listas criadas.</p>";
            }

            $conn->close();
            ?>
        </ul>
    </div>

    <div class="modal-overlay" id="modalOverlay">
        <div class="modal">
            <h2>Confirmação</h2>
            <p>Tem certeza que deseja excluir a lista <strong id="modalListaNome"></strong>?</p>
            <div>
                <button id="confirmDeleteBtn">Excluir</button>
                <button class="cancel" id="cancelBtn">Cancelar</button>
            </div>
        </div>
    </div>

    <script>
        const modalOverlay = document.getElementById('modalOverlay');
        const modalListaNome = document.getElementById('modalListaNome');
        const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');
        const cancelBtn = document.getElementById('cancelBtn');

        let listaIdParaExcluir = null;
        document.querySelectorAll('.btn-excluir').forEach(button => {
            button.addEventListener('click', () => {
                listaIdParaExcluir = button.dataset.id;
                modalListaNome.textContent = button.dataset.nome;
                modalOverlay.style.display = 'flex';
            });
        });

        confirmDeleteBtn.addEventListener('click', () => {
            if (!listaIdParaExcluir) return;
            window.location.href = `../../../back_end/listas/excluir_lista.php?id=${listaIdParaExcluir}`;
        });

        cancelBtn.addEventListener('click', () => {
            modalOverlay.style.display = 'none';
        });

        modalOverlay.addEventListener('click', e => {
            if (e.target === modalOverlay) modalOverlay.style.display = 'none';
        });
    </script>
</body>

</html>