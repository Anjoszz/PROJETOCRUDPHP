<?php
session_start();
require_once('../administrador/conexao.php');
 
if (!isset($_SESSION['admin_logado'])) {
    header("Location:login.php");
    exit();
}
 
$adm_id = $_GET['id'];
 
// Busca as informações do produto.
$stmt_adm = $pdo->prepare("SELECT * FROM ADMINISTRADOR WHERE ADM_ID = :adm_id");
$stmt_adm->bindParam(':adm_id', $adm_id, PDO::PARAM_INT);
$stmt_adm->execute();
$produto = $stmt_adm->fetch(PDO::FETCH_ASSOC);
  
// Busca as imagens do produto.
$stmt_img = $pdo->prepare("SELECT * FROM ADMINISTRADOR WHERE ADM_ID = :adm_id ");
$stmt_img->bindParam(':adm_id', $adm_id, PDO::PARAM_INT);
$stmt_img->execute();
$imagens_existentes = $stmt_img->fetchAll(PDO::FETCH_ASSOC);
 
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Atualizando as URLs das imagens.
    if (isset($_POST['editar_imagem_url'])) {
        foreach ($_POST['editar_imagem_url'] as $imagem_id => $url_editada) {
            $stmt_update = $pdo->prepare("UPDATE ADMINISTRADOR SET ADM_IMAGEM = :url WHERE ADM_ID = :imagem_id");
            $stmt_update->bindParam(':url', $url_editada, PDO::PARAM_STR);
            $stmt_update->bindParam(':imagem_id', $imagem_id, PDO::PARAM_STR);
            $stmt_update->execute();
        }
    }
 
    // Atualizando as informações do produto.
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $ativo = isset($_POST['ativo']) ? 1 : 0;

 
    try {
        $stmt_update_produto = $pdo->prepare("UPDATE ADMINISTRADOR SET ADM_NOME = :nome, ADM_EMAIL = :email, ADM_SENHA = :senha, ADM_ID = :adm_id, ADM_ATIVO = :ativo WHERE ADM_ID = :adm_id");
        $stmt_update_produto->bindParam(':nome', $nome);
        $stmt_update_produto->bindParam(':email', $email);
        $stmt_update_produto->bindParam(':senha', $senha);
        $stmt_update_produto->bindParam(':ativo', $ativo);
        $stmt_update_produto->bindParam(':adm_id', $adm_id);
        $stmt_update_produto->execute();
 
        echo "<p style='color:green;'>Produto atualizado com sucesso!</p>";
    } catch (PDOException $e) {
        echo "<p style='color:red;'>Erro ao atualizar produto: " . $e->getMessage() . "</p>";
    }
}
 
?>
<!DOCTYPE html>
<html lang="pt">
<head>
<meta charset="UTF-8">
<title>Editar Administrador</title>
<link rel="stylesheet" href="estilo_editar2.css">
</head>
<body>
<h2>Editar Administrador</h2>
<form action="" method="post" enctype="multipart/form-data">
<label for="nome">Nome:</label>
<input type="text" name="nome" id="nome" value="<?= $produto['ADM_NOME'] ?>" required>
<p>
<label for="descricao">Email:</label>
<textarea name="email" id="email" required><?= $produto['ADM_EMAIL'] ?></textarea>
<p>
<label for="senha">Senha:</label>
<input type="text" name="senha" id="senha" value="<?= $produto['ADM_SENHA'] ?>" required>
<p>
<label for="ativo">Ativo:</label>
<input type="checkbox" name="ativo" id="ativo" value="1" <?= $produto['ADM_ATIVO'] ? 'checked' : '' ?>>
<p>
<!-- Lista de imagens existentes -->
<?php 
    foreach($imagens_existentes as $imagem) {
        echo '<div>';
        echo '<label>URL da Imagem:</label>';
        echo '<input type="text" name="editar_imagem_url[' . $imagem['ADM_ID'] . ']" value="' . $imagem['ADM_IMAGEM'] . '">';
        echo '</div>';
    }
    ?>
<p>
<button type="submit">Atualizar Administrador</button>

<button><a href="listar_adm.php">Voltar</a></button>
</form>
</body>
</html>