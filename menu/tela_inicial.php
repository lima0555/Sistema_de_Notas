<?php
// Inicia a sessão
session_start();

// Verifica se o usuário está logado, se não, redireciona
if (!isset($_SESSION['user_id'])) {
    header("Location: ../entrada/login.php");
    exit();
}

// Inclui o arquivo de conexão
include '../entrada/conexao.php';

// Pega o ID e o nome do usuário logado
$usuario_id = $_SESSION['user_id'];
$usuario_nome = $_SESSION['user_name'];

// Define a consulta SQL base para buscar as notas do usuário
$sql = "SELECT id, titulo, conteudo, categoria, data_criacao FROM notas WHERE usuario_id = ?";
$params = ["i", $usuario_id];

// Verifica se uma categoria foi selecionada na URL (filtro)
if (isset($_GET['categoria']) && $_GET['categoria'] != '') {
    $categoria_selecionada = $_GET['categoria'];
    
    // Adiciona a cláusula WHERE para filtrar por categoria
    $sql .= " AND categoria = ?";
    
    // Adiciona o tipo e o valor do parâmetro para a categoria
    $params[0] .= "s";
    $params[] = $categoria_selecionada;
}

// Ordena as notas da mais recente para a mais antiga
$sql .= " ORDER BY data_criacao DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param(...$params);
$stmt->execute();
$result = $stmt->get_result();

// Mapeia categorias para cores de fundo
$cores_categorias = [
    'Estudos' => '#ffeb3b', 
    'Compras' => '#67e9f3', 
    'Trabalho' => '#b388ff', 
    'Geral' => '#ffffff'   
];
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Minhas Notas - EasyNotes</title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f2f5;
            margin: 0;
            padding: 20px;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 20px;
            background-color: #fff;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .header .icons {
            display: flex;
            gap: 15px;
            color: #555;
        }
        .header .icons span {
            font-size: 24px;
        }
        .header .user-info {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .header .vip {
            background-color: #ff9800;
            color: #fff;
            padding: 2px 8px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: bold;
        }
        .header .user-icon {
            width: 30px;
            height: 30px;
            background-color: #ccc;
            border-radius: 50%;
        }
        .categories {
            display: flex;
            gap: 10px;
            padding: 15px 20px;
            background-color: #fff;
            border-bottom: 1px solid #ddd;
        }
        .category-item {
            padding: 8px 15px;
            border-radius: 20px;
            background-color: #e0e0e0;
            font-weight: bold;
            color: #555;
            cursor: pointer;
            text-decoration: none;
            transition: background-color 0.3s, color 0.3s;
        }
        .category-item.active {
            background-color: #2196f3;
            color: #fff;
        }
        .main-content {
            padding: 20px;
        }
        .note-card {
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            word-wrap: break-word;
        }
        .note-title {
            font-size: 1.5em;
            font-weight: bold;
            margin-top: 0;
            margin-bottom: 10px;
        }
        .note-content {
            font-size: 1em;
            color: #444;
            white-space: pre-wrap;
        }
        .note-category {
            font-size: 0.9em;
            color: #666;
            font-weight: bold;
            text-transform: uppercase;
        }
        .note-date {
            font-size: 0.9em;
            color: #666;
        }
        .add-button-container {
            position: fixed;
            bottom: 30px;
            right: 30px;
            z-index: 1000;
            text-decoration: none;
        }
        .add-button {
            width: 60px;
            height: 60px;
            background-color: #2196f3;
            color: #fff;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 40px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            cursor: pointer;
            text-decoration: none;
            transition: transform 0.2s;
        }
        .add-button:hover {
            transform: scale(1.1);
        }

        .note-actions {
        margin-top: 15px;
        text-align: right;
    }
    .note-actions .action-button {
        color: #fff;
        padding: 5px 10px;
        border-radius: 5px;
        text-decoration: none;
        font-size: 0.9em;
        margin-left: 10px;
    }
    .note-actions .edit-button {
        background-color: #2196f3;
    }
    .note-actions .edit-button:hover {
        background-color: #1e87e5;
    }
    .note-actions .delete-button {
        background-color: #dc3545;
    }
    .note-actions .delete-button:hover {
        background-color: #c82333;
    }
    </style>
</head>
<body>
    
    <div class="welcome-message"  style="padding: 15px 20px; font-weight: bold;">Seja Bem Vindo, <?php echo htmlspecialchars($usuario_nome); ?>! =]</div>
    <div class="categories">
        <a href="tela_inicial.php" class="category-item <?php echo (!isset($_GET['categoria']) || $_GET['categoria'] == '') ? 'active' : ''; ?>">Todos</a>
        <a href="tela_inicial.php?categoria=Estudos" class="category-item <?php echo (isset($_GET['categoria']) && $_GET['categoria'] == 'Estudos') ? 'active' : ''; ?>">Estudos</a>
        <a href="tela_inicial.php?categoria=Compras" class="category-item <?php echo (isset($_GET['categoria']) && $_GET['categoria'] == 'Compras') ? 'active' : ''; ?>">Compras</a>
        <a href="tela_inicial.php?categoria=Trabalho" class="category-item <?php echo (isset($_GET['categoria']) && $_GET['categoria'] == 'Trabalho') ? 'active' : ''; ?>">Trabalho</a>
    </div>
    

    <div class="main-content">
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $cor_fundo = isset($cores_categorias[$row['categoria']]) ? $cores_categorias[$row['categoria']] : '#ffffff';
                echo '<div class="note-card" style="background-color: ' . htmlspecialchars($cor_fundo) . ';">';
                echo '    <p class="note-category">' . htmlspecialchars($row['categoria']) . '</p>';
                echo '    <h3 class="note-title">' . htmlspecialchars($row['titulo']) . '</h3>';
                echo '    <p class="note-content">' . nl2br(htmlspecialchars($row['conteudo'])) . '</p>';
                echo '    <p class="note-date">' . date('d/m/Y H:i', strtotime($row['data_criacao'])) . '</p>';
                

                echo '<div class="note-actions">';
                echo '<a href="edita_nota.php?id=' . $row['id'] . '" class="action-button edit-button">Editar</a>';
                echo '<a href="deleta_nota.php?id=' . $row['id'] . '" class="action-button delete-button" onclick="return confirm(\'Tem certeza que deseja excluir esta nota?\');">Excluir</a>';
                echo '</div>';

                echo '</div>';
            }
        } else {
            echo "<p style='text-align: center;'>Você ainda não tem notas nesta categoria. Clique em 'Criar Nova Nota' para começar!</p>";
        }
        ?>
    </div>

    <a href="nova_nota.php" class="add-button-container">
        <div class="add-button">+</div>
    </a>
    

</body>
</html>