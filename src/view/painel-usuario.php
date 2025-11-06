<?php
session_start();
if (!isset($_SESSION['user'])) {
  $_SESSION['login_error'] = "Faça o login para acessar o Painel de usuário!";
  header("Location: ./login-index.php");
  die;
}

// Incluir funcionalidades do painel do usuário
include_once '../service/conexao.php';
$conexao = instance2();

// Buscar posts do usuário atual
$userPosts = array();
if (isset($_SESSION['user']['userID'])) {
    $userID = $_SESSION['user']['userID'];
    $sql_posts = "SELECT p.*, c.descricao_categoria 
                  FROM post p 
                  LEFT JOIN categoria_post c ON p.categoria_postID = c.categoria_postID 
                  WHERE p.userID = ? 
                  ORDER BY p.criado_em DESC";
    $stmt = $conexao->prepare($sql_posts);
    $stmt->bind_param("i", $userID);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $userPosts[] = $row;
        }
    }
    $stmt->close();
}

// Buscar categorias
$categorias = array();
$sql_categorias = "SELECT * FROM categoria_post";
$result_categorias = $conexao->query($sql_categorias);
if ($result_categorias && $result_categorias->num_rows > 0) {
    while ($row = $result_categorias->fetch_assoc()) {
        $categorias[] = $row;
    }
}

$conexao->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mortos de Fome - Painel de Usuário</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,200;1,14..32,200&family=Itim&family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&display=swap" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="style/painel-usuario-style.css">
    <link rel="icon" href="assets/marsal.png" type="image/png">
</head>

<body>
    <div class="main-content-rule">
        <section class="main-content-user">
            <aside class="navbar-side">
                <div class="side side-dashboard brand-icon">
                    <a class="navbar-brand" href="index.php"><img src="assets/logo.png" alt="Logo"></a>
                </div>
                <div class="side side-dashboard">
                    <a href="#" data-tab="dashboard">Dashboard</a>
                </div>
                <div class="side side-dashboard">
                    <a href="#" data-tab="postagens">Minhas Postagens</a>
                </div>
                <div class="side side-dashboard">
                    <a href="#" data-tab="nova-postagem">Nova Postagem</a>
                </div>
                <div class="side side-dashboard btn-down-logout">
                    <a href="../model/LogoutModel.php" style="text-decoration: none; color: inherit;">Logout</a>
                </div>
            </aside>
            <div class="content-panel">
                <!-- Dashboard -->
                <div class="tab-content" id="dashboard">
                    <div class="welcome">
                        <?php
                        if (isset($_SESSION['user']['username'])) {
                            echo "<h3>Seja bem-vindo " . htmlspecialchars($_SESSION['user']['username']) . " ao <br>Painel de Usuário!</h3>";
                        } else {
                            echo '<h3>Erro ao carregar usuário.</h3>';
                        }
                        ?>
                    </div>
                    <div class="stats mt-4">
                        <div class="stat-card">
                            <h4>Minhas Postagens</h4>
                            <p><?php echo count($userPosts); ?></p>
                        </div>
                        <div class="stat-card">
                            <h4>Postagens Aprovadas</h4>
                            <p><?php echo count(array_filter($userPosts, function($post) { return $post['autorizado'] == 1; })); ?></p>
                        </div>
                        <div class="stat-card">
                            <h4>Postagens Pendentes</h4>
                            <p><?php echo count(array_filter($userPosts, function($post) { return $post['autorizado'] == 0; })); ?></p>
                        </div>
                    </div>
                </div>

                <!-- Minhas Postagens -->
                <div class="tab-content" id="postagens" style="display: none;">
                    <div class="welcome">
                        <h4>Minhas Postagens</h4>
                    </div>
                    
                    <?php if (empty($userPosts)): ?>
                        <div class="alert alert-info mt-3">
                            Você ainda não criou nenhuma postagem. <a href="#" data-tab="nova-postagem" class="alert-link">Crie sua primeira receita!</a>
                        </div>
                    <?php else: ?>
                        <div class="table-responsive mt-3">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Título</th>
                                        <th>Categoria</th>
                                        <th>Data</th>
                                        <th>Status</th>
                                        <th>Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($userPosts as $post): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($post['nome_post']); ?></td>
                                        <td><?php echo htmlspecialchars($post['descricao_categoria'] ?? 'Sem categoria'); ?></td>
                                        <td><?php echo date('d/m/Y H:i', strtotime($post['criado_em'])); ?></td>
                                        <td>
                                            <span class="badge <?php echo $post['autorizado'] ? 'bg-success' : 'bg-warning'; ?>">
                                                <?php echo $post['autorizado'] ? 'Aprovado' : 'Pendente'; ?>
                                            </span>
                                        </td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-primary">Editar</button>
                                            <button class="btn btn-sm btn-outline-danger">Excluir</button>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Nova Postagem -->
                <div class="tab-content" id="nova-postagem" style="display: none;">
                    <div class="welcome">
                        <h4>Criar Nova Receita</h4>
                    </div>
                    
                    <div class="card mt-3">
                        <div class="card-body">
                            <form action="../controller/PostController.php" method="POST" enctype="multipart/form-data">
                                <div class="mb-3">
                                    <label for="recipeTitle" class="form-label">Título da Receita *</label>
                                    <input type="text" class="form-control" id="recipeTitle" name="nome-receita" required maxlength="255">
                                </div>
                                <div class="mb-3">
                                    <label for="recipeCategory" class="form-label">Categoria *</label>
                                    <select class="form-select" id="recipeCategory" name="categoria-receita" required>
                                        <option value="">Selecione uma categoria</option>
                                        <?php foreach ($categorias as $categoria): ?>
                                        <option value="<?php echo $categoria['categoria_postID']; ?>">
                                            <?php echo htmlspecialchars($categoria['descricao_categoria']); ?>
                                        </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="recipeIngredients" class="form-label">Ingredientes *</label>
                                    <textarea class="form-control" id="recipeIngredients" rows="4" name="ingredientes-receita" required placeholder="Liste os ingredientes, separando por linha ou vírgula..."></textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="recipeInstructions" class="form-label">Modo de Preparo *</label>
                                    <textarea class="form-control" id="recipeInstructions" rows="6" name="modo-receita" required placeholder="Descreva o passo a passo do preparo..."></textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="tempoPreparo" class="form-label">Tempo de Preparo (minutos)</label>
                                    <input type="number" class="form-control" id="tempoPreparo" name="tempo-preparo" min="1" max="480" placeholder="Ex: 30">
                                </div>
                                <div class="mb-3">
                                    <label for="recipeImage" class="form-label">Imagem da Receita</label>
                                    <input type="file" class="form-control" id="recipeImage" name="imagens-receita[]" multiple accept="image/*">
                                    <div class="form-text">Formatos aceitos: JPG, PNG, GIF. Tamanho máximo: 5MB por imagem.</div>
                                </div>
                                <div class="d-grid gap-2">
                                    <button type="submit" class="btn btn-primary">Enviar para Aprovação</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <script>
        const links = document.querySelectorAll('.side-dashboard a[data-tab]');
        const tabs = document.querySelectorAll('.tab-content');

        links.forEach(link => {
          link.addEventListener('click', e => {
            e.preventDefault();
            const target = link.getAttribute('data-tab');

            tabs.forEach(tab => {
              tab.style.display = (tab.id === target) ? 'block' : 'none';
            });
          });
        });

        // Adicionar funcionalidade para links dentro do conteúdo
        document.addEventListener('DOMContentLoaded', function() {
            const contentLinks = document.querySelectorAll('a[data-tab]');
            contentLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    const target = this.getAttribute('data-tab');
                    
                    tabs.forEach(tab => {
                        tab.style.display = (tab.id === target) ? 'block' : 'none';
                    });
                });
            });
        });
    </script>
</body>
</html>