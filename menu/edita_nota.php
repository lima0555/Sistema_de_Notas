<?php
session_start();
include '../entrada/conexao.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../entrada/login.php");
    exit();
}

if (!isset($_GET['id'])) {
    header("Location: tela_inicial.php");
    exit();
}

$nota_id = $_GET['id'];
$usuario_id = $_SESSION['user_id'];

$sql = "SELECT titulo, conteudo, categoria FROM notas WHERE id = ? AND usuario_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $nota_id, $usuario_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "Nota não encontrada ou você não tem permissão para editá-la.";
    exit();
}

$nota = $result->fetch_assoc();
$titulo_nota = $nota['titulo'];
$conteudo_nota = $nota['conteudo'];
$categoria_nota = $nota['categoria'];
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Nota</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f2f5;
            padding: 20px;
        }
        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
        }
        form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }
        input[type="text"], textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box; 
        }
        textarea {
            resize: vertical;
            min-height: 150px;
        }
        .tags {
            display: flex;
            gap: 10px;
        }
        .tag-options {
            display: flex;
            gap: 10px;
        }
        .hidden-radio {
            display: none;
        }
        .tag-label {
            padding: 8px 15px;
            border: 1px solid #ccc;
            border-radius: 20px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .tag-label:hover {
            background-color: #f0f0f0;
        }
        .hidden-radio:checked + .tag-label {
            background-color: #2196f3;
            color: #fff;
            border-color: #2196f3;
        }
        .button-group {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
        }
        .button {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }
        .save-button {
            background-color: #28a745;
            color: white;
        }
        .cancel-button {
            background-color: #6c757d;
            color: white;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Editar Nota</h1>
        <form action="atualiza_nota.php" method="POST">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($nota_id); ?>">

            <input type="text" name="titulo" placeholder="Título da nota" required value="<?php echo htmlspecialchars($titulo_nota); ?>">
            <textarea name="conteudo" placeholder="Comece a escrever aqui..." required><?php echo htmlspecialchars($conteudo_nota); ?></textarea>
            
            <div class="tags">
                <p>Categorias:</p>
                <div class="tag-options">
                    <input type="radio" id="tag_estudos" name="categoria" value="Estudos" class="hidden-radio" <?php echo ($categoria_nota == 'Estudos') ? 'checked' : ''; ?>>
                    <label for="tag_estudos" class="tag-label">Estudos</label>

                    <input type="radio" id="tag_compras" name="categoria" value="Compras" class="hidden-radio" <?php echo ($categoria_nota == 'Compras') ? 'checked' : ''; ?>>
                    <label for="tag_compras" class="tag-label">Compras</label>

                    <input type="radio" id="tag_trabalho" name="categoria" value="Trabalho" class="hidden-radio" <?php echo ($categoria_nota == 'Trabalho') ? 'checked' : ''; ?>>
                    <label for="tag_trabalho" class="tag-label">Trabalho</label>

                    <input type="radio" id="tag_geral" name="categoria" value="Geral" class="hidden-radio" <?php echo ($categoria_nota == 'Geral') ? 'checked' : ''; ?>>
                    <label for="tag_geral" class="tag-label">Geral</label>
                </div>
            </div>

            <div class="button-group">
                <a href="tela_inicial.php" class="button cancel-button">Cancelar</a>
                <button type="submit" class="button save-button">Salvar Alterações</button>
            </div>
        </form>
    </div>
</body>
</html>