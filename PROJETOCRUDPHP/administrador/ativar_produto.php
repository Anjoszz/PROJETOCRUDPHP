<?php
session_start();

if (!isset($_SESSION['admin_logado'])) {
    header('Location: login.php');
    exit();
}

require_once('../administrador/conexao.php');

$mensagem = '';

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['id'])) {
    $id = $_GET['id'];
    $novoEstado = 1; // Define o estado como inativo (0)
    try {
        $stmt = $pdo->prepare("UPDATE PRODUTO SET PRODUTO_ATIVO = :novoEstado WHERE PRODUTO_ID = :id");
        $stmt->bindParam(':novoEstado', $novoEstado, PDO::PARAM_INT);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $mensagem = "Produto ativado com sucesso!";
        } else {
            $mensagem = "Não foi possível ativar o produto.";
        }
    } catch (PDOException $e) {
        $mensagem = "Erro: " . $e->getMessage();
    }
}

header("Location: listar_produtos.php?mensagem=" . urlencode($mensagem));
exit();
?>


<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Excluir Produto</title>
    <link rel="stylesheet" href="./estilo_excluir.css">
</head>
<body>
    <h2 class="text">Excluir Produto</h2>
        <p class="text"><?php echo $mensagem; ?></p>
        <button>
            <a href="listar_produtos.php">Voltar à Lista de Produtos</a>
        </button>

        <?php if ($mensagem !== "Produto inativado com sucesso!") { ?>
            <h2>Não foi possível inativar o produto</h2>
        <?php } ?>
</body>
</html>