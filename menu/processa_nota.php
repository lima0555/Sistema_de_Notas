<?php
session_start();
include '../entrada/conexao.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario_id = $_SESSION['user_id'];
    $titulo = $_POST['titulo'];
    $conteudo = $_POST['conteudo'];
    
    $categoria = isset($_POST['categoria']) ? $_POST['categoria'] : 'Geral';
    
    $sql = "INSERT INTO notas (titulo, conteudo, usuario_id, categoria) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    
    $stmt->bind_param("ssis", $titulo, $conteudo, $usuario_id, $categoria);

    if ($stmt->execute()) {
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nota Salva</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f2f5;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            text-align: center;
            background-color: #fff;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .container h1 {
            color: #28a745;
            font-size: 2.5em;
        }
        .container p {
            font-size: 1.2em;
            color: #555;
            margin-bottom: 20px;
        }
        .container a {
            padding: 10px 20px;
            background-color: #2196f3;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            transition: background-color 0.2s;
        }
        .container a:hover {
            background-color: #1e87e5;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Sucesso!</h1>
        <p>Sua nota foi criada com sucesso.</p>
        <a href="tela_inicial.php">Voltar para a tela inicial</a>
    </div>
</body>
</html>
<?php
        exit(); 
    } else {
        echo "Erro ao salvar a nota: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    header("Location: tela_inicial.php");
    exit();
}
?>