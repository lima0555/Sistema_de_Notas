<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../entrada/login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nova Nota - EasyNotes</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f2f5;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 700px;
            margin: auto;
            background-color: #fff;
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        h1 {
            color: #333;
            text-align: center;
        }
        p{
            color: #333;
            text-align:left;
            font-size:22px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #555;
        }
        .form-group input[type="text"] {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 6px;
            box-sizing: border-box;
            font-size: 16px;
        }
        .form-group textarea {
            width: 100%;
            height: 250px;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 6px;
            box-sizing: border-box;
            font-size: 16px;
            resize: vertical;
        }
        .form-group button {
            width: 100%;
            padding: 15px;
            background-color: #28a745;
            color: #fff;
            border: none;
            border-radius: 6px;
            font-size: 18px;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.2s;
        }
        .form-group button:hover {
            background-color: #218838;
        }
        .back-link {
            display: block;
            text-align: center;
            margin-top: 20px;
            text-decoration: none;
            color: #007bff;
        }
        .back-link:hover {
            text-decoration: underline;
        }
        .tag-options {
            padding-bottom: 12px;
            display: flex;
            gap: 10px;
        }
        .hidden-radio {
            display: none; 
        }
        .tag-label {
            padding: 8px 15px;
            border-radius: 20px;
            background-color: #e0e0e0;
            font-weight: bold;
            color: #555;
            cursor: pointer;
            transition: background-color 0.3s, color 0.3s;
        }
        .tag-label:hover {
            background-color: #d0d0d0;
        }
        .hidden-radio:checked + .tag-label {
            background-color: #2196f3;
            color: #fff;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Criar Nova Nota</h1>
        <form action="processa_nota.php" method="POST">
            <div class="form-group">
                <label for="titulo">Título da Nota</label>
                <input type="text" id="titulo" name="titulo" required>
            </div>
            <div class="form-group">
                <label for="conteudo">Conteúdo da Nota</label>
                <textarea id="conteudo" name="conteudo" required></textarea>
            </div>

            <p>Tags</p>
            <div class="tag-options">
                <input type="radio" id="tag_estudos" name="categoria" value="Estudos" class="hidden-radio">
                <label for="tag_estudos" class="tag-label">Estudos</label>

                <input type="radio" id="tag_compras" name="categoria" value="Compras" class="hidden-radio">
                <label for="tag_compras" class="tag-label">Compras</label>

                <input type="radio" id="tag_trabalho" name="categoria" value="Trabalho" class="hidden-radio">
                <label for="tag_trabalho" class="tag-label">Trabalho</label>
            </div>



            
            <div class="form-group">
                <button type="submit">Salvar Nota</button>
            </div>
        </form>
        <a href="tela_inicial.php" class="back-link">Voltar para a tela inicial</a>
    </div>
</body>
</html>