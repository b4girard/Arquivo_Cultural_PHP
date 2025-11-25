<?php
session_start();
include "../controle/conexao.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['e_mail'] ?? '';
    $senha = $_POST['senha'] ?? '';

    if (empty($email) || empty($senha)) {
        die("Preencha todos os campos.");
    }


    $sql = $conn->prepare("SELECT ID_usuario, Nome, Senha, Tipo_usuario FROM usuario WHERE E_mail = ?");
    $sql->bind_param("s", $email);
    $sql->execute();

    $sql->bind_result($id, $nome, $hashSenha, $tipoUsuario);

    if ($sql->fetch()) {
        if (password_verify($senha, $hashSenha)) {
            $_SESSION['ID_usuario'] = $id;
            $_SESSION['nome'] = $nome;
            $_SESSION['e_mail'] = $email;
            $_SESSION['tipo_usuario'] = $tipoUsuario;

            if ($tipoUsuario === 'administrador') {
                echo "<script type='text/javascript'>
                    alert('Login realizado com sucesso!');
                    window.location.href = 'entrada_ADM.php';
                  </script>";
                exit;
            }

            echo "<script type='text/javascript'>
                    alert('Login realizado com sucesso!');
                    window.location.href = '../../front_end/usuario/entrada/entrada.php';
                  </script>";
            exit;
        } else {
            die("<script type='text/javascript'>
                    alert('Usuário ou senha incorreto');
                    window.location.href = '../../front_end/login.php';
                  </script>");
        }
    } else {
        die("<script type='text/javascript'>
                    alert('Usuário não cadastrado.');
                    window.location.href = '../../front_end/cadastro.php';
                  </script>");
    }

    $sql->close();
    $conn->close();
}
?>