<?php
session_start(); // Iniciar a sessão

if (!isset($_SESSION['admin_logado'])) {
    header('Location: login.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Painel do Administrador</title>
    <link rel="stylesheet" href="./estilo_painel.css">
</head>
<body>
    <h2 class="text">Bem-vindo, Administrador!</h2>
    <div class="btn-style">
        <a href="cadastrar_produto.php">
            <button>Cadastrar Produto</button>
        </a>
        <a href="listar_produtos.php">
            <button>Listar Produtos</button>
        </a>
        </a>
        <a href="cadastrar_admin.php">
            <button>cadastrar Administrador</button>
        </a>
        <a href="listar_adm.php">
            <button>Listar Administrador</button>
        </a>
        <a href="cadastrar_categoria.php">
            <button>Cadastrar categoria</button>
        </a>
        <a href="listar_categoria.php">
            <button>Listar categoria</button>
        </a>
    </div>
</body>
</html>