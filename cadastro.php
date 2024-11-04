<?php
session_start(); // Inicia a sessão
require 'conexao.php'; // Inclua seu arquivo de conexão aqui

// Verifica se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $link = $_POST['link'];

    // Preparar e executar a inserção no banco de dados
    $sql = "INSERT INTO videos (nome, link) VALUES (:nome, :link)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':nome', $nome);
    $stmt->bindParam(':link', $link);
    $stmt->execute();

    // Define a mensagem de sucesso na sessão
    $_SESSION['message'] = 'Vídeo cadastrado com sucesso!';

    // Redirecionar para a mesma página para exibir a mensagem
    header('Location: cadastro.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastro de Vídeo</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        /* CSS do formulário */
        body {
            margin: 0;
            padding: 0;
            background: #1e3a8a; /* Fundo azul escuro */
            font-family: 'Arial', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            color: #fff;
        }

        .login-box {
            width: 400px;
            padding: 40px;
            background: #ffffff1a; /* Fundo transparente com leve opacidade */
            box-shadow: 0 15px 25px rgba(0, 0, 0, 0.5);
            border-radius: 10px;
            text-align: center;
        }

        .login-box h2 {
            margin-bottom: 30px;
            color: #ffffff;
            font-size: 24px;
        }

        .login-box .user-box {
            position: relative;
            margin-bottom: 30px;
        }

        .login-box .user-box input {
            width: 100%;
            padding: 10px 0;
            font-size: 18px;
            color: #ffffff;
            border: none;
            border-bottom: 2px solid #ffffff;
            outline: none;
            background: transparent;
            transition: border-color 0.3s;
        }

        .login-box .user-box input:focus {
            border-color: #4ade80; /* Verde claro */
        }

        .login-box .user-box label {
            position: absolute;
            top: 0;
            left: 0;
            padding: 10px 0;
            font-size: 18px;
            color: #b0c4de;
            pointer-events: none;
            transition: 0.5s;
        }

        .login-box .user-box input:focus ~ label,
        .login-box .user-box input:valid ~ label {
            top: -20px;
            left: 0;
            font-size: 14px;
            color: #4ade80;
        }

        .login-box form a {
            display: inline-block;
            background: #3b82f6; /* Azul vibrante */
            color: #ffffff;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            font-size: 16px;
            font-weight: bold;
            transition: background 0.3s, color 0.3s;
            margin-top: 20px;
        }

        .login-box form a:hover {
            background: #2563eb; /* Azul mais escuro para o hover */
            color: #ffffff;
            box-shadow: 0 5px 15px rgba(37, 99, 235, 0.3);
        }
    </style>
</head>
<body>
    <div class="login-box">
        <h2>Cadastro de Vídeo:</h2>

        <?php
        // Verifica se há uma mensagem de sucesso na sessão
        if (isset($_SESSION['message'])) {
            echo '<div class="alert alert-success" role="alert">' . $_SESSION['message'] . '</div>';
            unset($_SESSION['message']); // Limpa a mensagem após exibi-la
        }
        ?>

        <form method="POST" action="">
            <div class="user-box">
                <input type="text" name="nome" required>
                <label>Nome do Vídeo:</label>
            </div>
            <div class="user-box">
                <input type="url" name="link" required>
                <label>Link do Vídeo:</label>
            </div>
            <a href="#" onclick="this.closest('form').submit();">
                Cadastrar
            </a>
        </form>
    </div>
</body>
</html>
        