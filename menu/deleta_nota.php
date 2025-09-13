<?php
session_start();
include '../entrada/conexao.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../entrada/login.php");
    exit();
}

if (isset($_GET['id'])) {
    $nota_id = $_GET['id'];
    $usuario_id = $_SESSION['user_id'];
    
    
    $sql = "DELETE FROM notas WHERE id = ? AND usuario_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $nota_id, $usuario_id);

    if ($stmt->execute()) {
        header("Location: tela_inicial.php");
        exit();
    } else {
        echo "Erro ao tentar excluir a nota: " . $stmt->error;
    }
    
    $stmt->close();
    $conn->close();

} else {
    header("Location: tela_inicial.php");
    exit();
}
?>