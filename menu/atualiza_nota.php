<?php
session_start();
include '../entrada/conexao.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../entrada/login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_nota = $_POST['id'];
    $titulo_novo = $_POST['titulo'];
    $conteudo_novo = $_POST['conteudo'];
    $categoria_nova = $_POST['categoria'];
    $usuario_id = $_SESSION['user_id'];

    $sql = "UPDATE notas SET titulo = ?, conteudo = ?, categoria = ? WHERE id = ? AND usuario_id = ?";
    $stmt = $conn->prepare($sql);
    
    $stmt->bind_param("sssii", $titulo_novo, $conteudo_novo, $categoria_nova, $id_nota, $usuario_id);

    if ($stmt->execute()) {
        header("Location: tela_inicial.php");
        exit();
    } else {
        echo "Erro ao atualizar a nota: " . $stmt->error;
    }
    
    $stmt->close();
    $conn->close();

} else {
    header("Location: tela_inicial.php");
    exit();
}
?>