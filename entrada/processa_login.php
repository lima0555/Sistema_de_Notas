<?php
session_start();


include 'conexao.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $sql = "SELECT id, nome, email, senha FROM usuarios WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {

        $usuario = $result->fetch_assoc();

        if (password_verify($senha, $usuario['senha'])) {
            $_SESSION['user_id'] = $usuario['id'];
            $_SESSION['user_name'] = $usuario['nome'];

            // === ATENÇÃO AQUI! O redirecionamento precisa sair da pasta 'entrada' e ir para a pasta 'menu' ===
            header("Location: ../menu/tela_inicial.php");
            exit();
        } else {
            // Senha incorreta
            header("Location: login.php?erro=1");
            exit();
        }
    } else {
        // Usuário não encontrado
        header("Location: login.php?erro=1");
        exit();
    }

    $stmt->close();
    $conn->close();
}
?>