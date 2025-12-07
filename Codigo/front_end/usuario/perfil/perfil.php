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
    <title>Perfil</title>
    <link rel="stylesheet" href="../../../css/perfil.css">
    <link rel="stylesheet" href="../../../css/modal_saida.css">
    <style>
        .filtros {
            display: flex;
            justify-content: center;
            gap: 12px;
            margin-bottom: 20px;
        }

        .filtro-btn {
            padding: 8px 20px;
            border: none;
            border-radius: 25px;
            background-color: #3c6eac;
            color: #fff;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .filtro-btn.active {
            background-color: #b67ebc;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
            transform: scale(1.05);
        }

        .filtro-btn:hover {
            background-color: #5a85c0;
            transform: translateY(-2px);
        }


        .filtro-btn:active {
            transform: translateY(0);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>

<body>

    <div class="container">

        <a class="voltar" href="../entrada/entrada.php">← Voltar para Home</a>

        <div class="card">
            <h1 class="titulo">Seu Perfil</h1>

            <div class="botoes">
                <form action="editar.php" method="post">
                    <button class="btn editar">Editar Perfil</button>
                </form>

                <button class="btn logout" onclick="mostrarLogoutModal()">Logout</button>

                <div class="modal-overlay" id="logoutModal">
                    <div class="modal">
                        <h2>Confirmação</h2>
                        <p>Tem certeza que deseja sair?</p>
                        <button onclick="confirmarLogout()">Sim, sair</button>
                        <button class="cancel" onclick="fecharLogoutModal()">Cancelar</button>
                    </div>
                </div>

                <form id="logoutForm" action="../../../back_end/perfil/logout.php" method="post" style="display:none;">
                </form>
            </div>

            <div class="info">
                <p><strong>Usuário:</strong> <?= htmlspecialchars($usuario['Usuario']) ?></p>
                <p><strong>Nome:</strong> <?= htmlspecialchars($usuario['Nome']) ?></p>
                <p><strong>E-mail:</strong> <?= htmlspecialchars($usuario['E_mail']) ?></p>

                <div class="filtros">
                    <button class="filtro-btn active" onclick="filtrar('todos')">Todos</button>
                    <button class="filtro-btn" onclick="filtrar('livros')">Livros</button>
                    <button class="filtro-btn" onclick="filtrar('filmes')">Filmes</button>
                </div>
            </div>
        </div>

        <div class="avaliacoes">
            <h2>Minhas Avaliações</h2>

            <?php
            function mostrarAvaliacoes($stmt, $tipo, $ID_usuario)
            {
                $stmt->bind_param("i", $ID_usuario);
                $stmt->execute();
                $result = $stmt->get_result();

                echo "<div class='box-avaliacao $tipo'>";
                echo $tipo == 'livros' ? "<h3>📚 Livros</h3>" : "<h3>🎬 Filmes</h3>";

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $data = date("d/m/Y", strtotime($row['Data_avaliacao']));
                        echo "<div class='item'>
                        <p><strong>" . htmlspecialchars($row['Titulo']) . "</strong> <span style='font-size:12px;color:#777;'>($data)</span></p>
                        <p class='nota'>" . htmlspecialchars($row['Nota']) . " ⭐</p>
                        <p class='comentario'>" . htmlspecialchars($row['Comentario'] ?: '-') . "</p>
                        <div class='acoes-item'>
                            <button class='excluir-item' onclick='mostrarExcluirModal(" . $row['ID_avaliacao'] . ")'>Excluir</button>
                        </div>
                    </div>";
                    }
                } else {
                    echo "<p class='vazio'>Você ainda não avaliou nenhum " . ($tipo == 'livros' ? 'livro' : 'filme') . ".</p>";
                }
                echo "</div>";
                $stmt->close();
            }

            $stmtLivros = $conn->prepare("
            SELECT a.ID_avaliacao, l.Titulo, a.Nota, a.Comentario, a.Data_avaliacao
            FROM avaliacao a
            JOIN livro l ON a.ID_livro = l.ID_Livro
            WHERE a.ID_usuario = ?
            ORDER BY a.Data_avaliacao DESC
        ");
            mostrarAvaliacoes($stmtLivros, 'livros', $ID_usuario);

            $stmtFilmes = $conn->prepare("
            SELECT a.ID_avaliacao, f.Titulo, a.Nota, a.Comentario, a.Data_avaliacao
            FROM avaliacao a
            JOIN filme f ON a.ID_filme = f.ID_filme
            WHERE a.ID_usuario = ?
            ORDER BY a.Data_avaliacao DESC
        ");
            mostrarAvaliacoes($stmtFilmes, 'filmes', $ID_usuario);
            ?>

        </div>
    </div>

    <div class="modal-overlay" id="excluirModal">
        <div class="modal">
            <h2>Excluir Avaliação</h2>
            <p>Tem certeza que deseja excluir esta avaliação?</p>
            <form id="formExcluir" method="post" action="../../../back_end/listas/excluir_avaliacao.php">
                <input type="hidden" name="ID_avaliacao" id="ID_avaliacao">
                <button type="submit">Sim, excluir</button>
                <button type="button" class="cancel" onclick="fecharExcluirModal()">Cancelar</button>
            </form>
        </div>
    </div>

    <script>
        function mostrarLogoutModal() { document.getElementById('logoutModal').style.display = 'flex'; }
        function fecharLogoutModal() { document.getElementById('logoutModal').style.display = 'none'; }
        function confirmarLogout() { document.getElementById('logoutForm').submit(); }

        function filtrar(tipo) {
            document.querySelectorAll('.filtro-btn').forEach(btn => btn.classList.remove('active'));
            event.currentTarget.classList.add('active');
            if (tipo === 'todos') {
                document.querySelectorAll('.box-avaliacao').forEach(box => box.style.display = 'block');
            } else {
                document.querySelectorAll('.box-avaliacao').forEach(box => {
                    box.style.display = box.classList.contains(tipo) ? 'block' : 'none';
                });
            }
        }

        function mostrarExcluirModal(ID) {
            document.getElementById('ID_avaliacao').value = ID;
            document.getElementById('excluirModal').style.display = 'flex';
        }
        function fecharExcluirModal() {
            document.getElementById('excluirModal').style.display = 'none';
        }
    </script>

</body>

</html>