<?php
session_start();

require_once('../administrador/conexao.php');

// Verifica se o administrador está logado.
if (!isset($_SESSION['admin_logado'])) {
    header("Location:login.php");
    exit();
}
if (isset($_GET['update']) && $_GET['update'] === 'success') {
  echo "<div id='messagee'>Categoria atualizada com sucesso!</div>";
}

try {
  $stmt = $pdo->prepare("SELECT 
    CATEGORIA_ID,
    CATEGORIA_NOME,
    CATEGORIA_DESC,
    CATEGORIA_ATIVO 
    FROM CATEGORIA
    ");
  $stmt->execute();
  $categorias = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $erro) {
  echo "Erro " . $erro->getMessage();
}

?>


    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Listar categoria</title>
        <link rel="stylesheet" href="estilo_listarcategoria.css">
    </head>
    <p>
    <button>
<a href="painel_admin.php">Voltar ao Painel do Administrador</a>
</button>
    <body>
        
              <table>
              <tr>
<th>ID</th>
<th>Nome</th>
<th>Descrição</th>
<th>Ativo</th>
<th>Editar</th>
<th>Ativar</th>
<th>Excluir</th>

</tr>
                <?php foreach ($categorias as $categoria) { ?>
                  <tr>
                    <td>
                      <?php echo $categoria['CATEGORIA_ID']; ?>
                    </td>
                    <td >
                      <?php echo $categoria['CATEGORIA_NOME']; ?>
                    </td>
                    <td>
                      <?php echo $categoria['CATEGORIA_DESC']; ?>
                    </td>
                    <td>
                      <?php
                      if ($categoria['CATEGORIA_ATIVO'] == 0) {
                        echo 'Inativo';
                      } else {
                        echo 'Ativo';
                      };
                      ?>
                    </td>
                    <td>
                        <button>
                      <a href="editar_categoria.php?CATEGORIA_ID=<?php echo $categoria['CATEGORIA_ID']; ?>" class="action-btn" data-toggle="tooltip" data-original-title="Edit user">
                        Editar
                      </a>
                      </button>
                    </td>
                    <td>
                    <?php if ($categoria['CATEGORIA_ATIVO'] == 0): ?>
                    <button>
                    <a href="ativar_categoria.php?id=<?php echo $categoria['CATEGORIA_ID']; ?>" class="action-btn">Ativar</a>
                    </button>
                    <?php endif; ?>
                    </td>
                    <td>
                    <?php if ($categoria['CATEGORIA_ATIVO'] == 1): ?>
                    <button>
                    <a href="desativar_categoria.php?id=<?php echo $categoria['CATEGORIA_ID']; ?>" class="action-btn">Desativar</a>
                    </button>
                    <?php endif; ?>
                    </td>
                  </tr>
                <?php } ?>
              </table>
              </body>
    </html>
    
