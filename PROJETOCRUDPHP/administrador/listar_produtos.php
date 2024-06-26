<?php
session_start();
require_once('../administrador/conexao.php');

if (!isset($_SESSION['admin_logado'])) {
    header("Location:login.php");
    exit();
}

try {
    // Prepara a consulta SQL para buscar os produtos, suas categorias, imagens e o estoque de cada produto
    $stmt = $pdo->prepare("SELECT PRODUTO.*, CATEGORIA.CATEGORIA_NOME, PRODUTO_IMAGEM.IMAGEM_URL, PRODUTO_ESTOQUE.PRODUTO_QTD
                           FROM PRODUTO 
                           JOIN CATEGORIA ON PRODUTO.CATEGORIA_ID = CATEGORIA.CATEGORIA_ID 
                           LEFT JOIN PRODUTO_IMAGEM ON PRODUTO.PRODUTO_ID = PRODUTO_IMAGEM.PRODUTO_ID
                           LEFT JOIN PRODUTO_ESTOQUE ON PRODUTO.PRODUTO_ID = PRODUTO_ESTOQUE.PRODUTO_ID");
    $stmt->execute(); // Executa a consulta
    $produtos = $stmt->fetchAll(PDO::FETCH_ASSOC); // Busca todos os registros retornados pela consulta
} catch (PDOException $e) {
    // Em caso de erro na consulta, exibe uma mensagem
    echo "<p style='color:red;'>Erro ao listar produtos: " . $e->getMessage() . "</p>";
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Listar Produtos</title>
    <link rel="stylesheet" href="estilo_listar.css">
</head>
<body>
<h2>Produtos Cadastrados</h2>
<table>
    <tr>
        <th>ID</th>
        <th>Nome</th>
        <th>Descrição</th>
        <th>Preço</th>
        <th>Categoria</th>
        <th>Ativo</th>
        <th>Desconto</th>
        <th>Estoque</th>
        <th>Imagem</th>
        <th>Ações</th>
    </tr>
    <?php foreach($produtos as $produto): ?>
    <tr>
        <td><?php echo $produto['PRODUTO_ID']; ?></td>
        <td><?php echo $produto['PRODUTO_NOME']; ?></td>
        <td><?php echo $produto['PRODUTO_DESC']; ?></td>
        <td><?php echo $produto['PRODUTO_PRECO']; ?></td>
        <td><?php echo $produto['CATEGORIA_NOME']; ?></td>
        <td><?php echo ($produto['PRODUTO_ATIVO'] == 1 ? 'Sim' : 'Não'); ?></td>
        <td><?php echo $produto['PRODUTO_DESCONTO']; ?></td>
        <td><?php echo $produto['PRODUTO_QTD']; ?></td> <!-- Exibe a quantidade em estoque do produto -->
        <td><img src="<?php echo $produto['IMAGEM_URL']; ?>" alt="<?php echo $produto['PRODUTO_NOME']; ?>" width="50"></td>
        <td>
            <a href="editar_produto.php?id=<?php echo $produto['PRODUTO_ID']; ?>" class="action-btn">Editar</a>
            <?php if ($produto['PRODUTO_ATIVO'] == 1): ?>
            <a href="desativar_produto.php?id=<?php echo $produto['PRODUTO_ID']; ?>" class="action-btn delete-btn">Desativar</a>
            <?php endif; ?>
            <?php if ($produto['PRODUTO_ATIVO'] == 0): ?>
            <a href="ativar_produto.php?id=<?php echo $produto['PRODUTO_ID']; ?>" class="action-btn delete-btn">Ativar</a>
            <?php endif; ?>
        </td>
</tr>

    <?php endforeach; ?>
</table>
    <p></p>
    <a href="painel_admin.php">Voltar ao Painel do Administrador</a>
</body>
</html>
