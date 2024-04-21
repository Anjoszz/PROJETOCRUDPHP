<?php
session_start();
require_once('../administrador/conexao.php');
 
if (!isset($_SESSION['admin_logado'])) {
    header("Location:login.php");
    exit();
}
 
try {
    $stmt = $pdo->prepare("SELECT ADMINISTRADOR.*, ADM_NOME, ADM_EMAIL, ADM_SENHA, ADM_ATIVO, ADM_IMAGEM 
                           FROM ADMINISTRADOR ");
    $stmt->execute();
    $administrador = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "<p style='color:red;'>Erro ao listar Adminstrador: " . $e->getMessage() . "</p>";
}
?>
 
<!DOCTYPE html>
<html lang="pt">
<head>
<meta charset="UTF-8">
<title>Listar Administradores</title>
<link rel="stylesheet" href="estilo_listar.css">
</head>
<body>
<h2>Listar Administradores</h2>
<button class = "action-btn"><a href="painel_admin.php" class="action-btn">Voltar ao Painel do Administrador</a></button>
<table>
<tr>
<th>ID</th>
<th>Nome</th>
<th>Email</th>
<th>Senha</th>
<th>Ativo</th>
<th>avatar</th>
<th>Ações</th>
</tr>
<?php foreach($administrador as $adm): ?>
<tr>
<td><?php echo $adm['ADM_ID']; ?></td>
<td><?php echo $adm['ADM_NOME']; ?></td>
<td><?php echo $adm['ADM_EMAIL']; ?></td>
<td><?php echo $adm['ADM_SENHA']; ?></td>
<td><?php echo ($adm['ADM_ATIVO'] == 1 ? 'Sim' : 'Não'); ?></td>
<td><img src="<?php echo $adm['ADM_IMAGEM']; ?>" alt= "<?php echo "A imagem do Administrador " . $adm['ADM_NOME'] . " não pode ser carregada"; ?>
 ?>" width="50"></td>
<td>
<a href="editar_adm.php?id=<?php echo $adm['ADM_ID']; ?>" class="action-btn">Editar</a>
</td>
</tr>
 
    <?php endforeach; ?>
</table>
<p></p>
<button class = "action-btn"><a href="painel_admin.php" class="action-btn">Voltar ao Painel do Administrador</a></button>
</body>
</html>