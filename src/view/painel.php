<?php
session_start();

if (!isset($_SESSION['user']['isAdmin']) || $_SESSION['user']['isAdmin'] != 1) {
    header("Location: ./login-index.php");
    die;
}

include_once '../service/conexao.php';

$conexao = instance2();

// Buscar categorias para o select
$categorias = array();
$sql_categorias = "SELECT * FROM categoria_post";
$result_categorias = $conexao->query($sql_categorias);
if ($result_categorias && $result_categorias->num_rows > 0) {
    while ($row = $result_categorias->fetch_assoc()) {
        $categorias[] = $row;
    }
}

// Buscar posts existentes
$posts = array();
$sql_posts = "SELECT p.*, u.username, c.descricao_categoria 
              FROM post p 
              LEFT JOIN user u ON p.userID = u.userID 
              LEFT JOIN categoria_post c ON p.categoria_postID = c.categoria_postID 
              ORDER BY p.criado_em DESC";
$result_posts = $conexao->query($sql_posts);
if ($result_posts && $result_posts->num_rows > 0) {
    while ($row = $result_posts->fetch_assoc()) {
        $posts[] = $row;
    }
}

// Fechar conexão
$conexao->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="icon" href="assets/marsal.png" type="image/png">
    <link rel="stylesheet" href="style/painel-style.css">
    <title>Mortos de Fome - Painel</title>
</head>
<body>
    <article class="page-main">
        <div class="Seila">
            <section class="nav-aside">
                <div class="side side-dashboard">
                    <a class="navbar-brand" href="#"><img src="assets/logo.png" alt="Logo"></a>
                </div>
                <div class="side side-dashboard">
                    <a href="#" data-tab="dashboard">Dashboard</a>
                </div>
                <div class="side side-dashboard">
                    <a href="#" data-tab="postagens">Postagens</a>
                </div>
                <div class="side side-dashboard">
                    <a href="#" data-tab="usuarios">Usuários</a>
                </div>
                <div class="side side-dashboard btn-down-logout">
                    <a href="../model/LogoutModel.php">Logout</a>
                </div>
            </section>
        </div>

        <div class="main-content">
            <!-- Dashboard -->
            <div class="tab-content" id="dashboard">
                <div class="welcome">
                    <h3>Seja bem-vindo <?php echo htmlspecialchars($_SESSION['user']['username']); ?> ao <br>Painel de Admin!</h3>
                </div>
                
                <!-- Mensagens de sucesso/erro -->
                <?php if (isset($_SESSION['success'])): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <?php echo $_SESSION['success']; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <?php unset($_SESSION['success']); ?>
                <?php endif; ?>
                
                <?php if (isset($_SESSION['error'])): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <?php echo $_SESSION['error']; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <?php unset($_SESSION['error']); ?>
                <?php endif; ?>
                
                <div class="stats">
                    <div class="stat-card">
                        <h4>Total de Posts</h4>
                        <p><?php echo count($posts); ?></p>
                    </div>
                    <div class="stat-card">
                        <h4>Posts Pendentes</h4>
                        <p><?php echo count(array_filter($posts, function($post) { return $post['autorizado'] == 0; })); ?></p>
                    </div>
                </div>
            </div>

            <!-- Postagens -->
            <div class="tab-content" id="postagens" style="display: none;">
                <div class="content">
                    <div class="welcome">
                        <p>Área de Postagem</p>
                    </div>

                    <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#CriarPostagemModal">
                        Criar Nova Postagem
                    </button>

                    <!-- Lista de Posts -->
                    <div class="posts-list">
                        <h4>Posts Existentes</h4>
                        <?php if (empty($posts)): ?>
                            <div class="alert alert-info">Nenhum post encontrado.</div>
                        <?php else: ?>
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
                                    <?php foreach ($posts as $post): ?>
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
                                            <button class="btn btn-sm btn-primary">Editar</button>
                                            <button class="btn btn-sm btn-danger">Excluir</button>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Modal de Criação -->
                <div class="modal fade" id="CriarPostagemModal" tabindex="-1" aria-labelledby="CriarPostagemModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="CriarPostagemModalLabel">Nova Receita</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                            </div>
                            <div class="modal-body">
                                <form id="recipeForm" action="../controller/PainelController.php" method="POST" enctype="multipart/form-data">
                                    <div class="mb-3">
                                        <label for="recipeTitle" class="form-label">Título da Receita *</label>
                                        <input type="text" class="form-control" id="recipeTitle" name="nome-receita" required maxlength="255">
                                    </div>
                                    <div class="mb-3">
                                        <label for="recipeSubtitle" class="form-label">Subtítulo</label>
                                        <input type="text" class="form-control" id="recipeSubtitle" name="subtitulo-receita" maxlength="255">
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
                                        <?php if (empty($categorias)): ?>
                                            <div class="text-danger mt-1">Nenhuma categoria cadastrada. É necessário criar categorias primeiro.</div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="mb-3">
                                        <label for="recipeIngredients" class="form-label">Ingredientes *</label>
                                        <textarea class="form-control" id="recipeIngredients" rows="3" name="ingredientes-receita" required placeholder="Liste os ingredientes, separando por linha ou vírgula..."></textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label for="recipeInstructions" class="form-label">Modo de Preparo *</label>
                                        <textarea class="form-control" id="recipeInstructions" rows="5" name="modo-receita" required placeholder="Descreva o passo a passo do preparo..."></textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label for="recipeImage" class="form-label">Imagem da Receita</label>
                                        <input type="file" class="form-control" id="recipeImage" name="imagens-receita[]" multiple accept="image/*">
                                        <div class="form-text">Formatos aceitos: JPG, PNG, GIF. Tamanho máximo: 5MB por imagem.</div>
                                    </div>
                                    <div class="d-grid gap-2">
                                        <button type="submit" class="btn btn-primary" <?php echo empty($categorias) ? 'disabled' : ''; ?>>Postar Receita</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Usuários -->
            <div class="tab-content" id="usuarios" style="display: none;">
                <div class="welcome">
                    <p>Gerenciamento de Usuários</p>
                </div>
                <div class="alert alert-info">
                    Funcionalidade em desenvolvimento. Em breve você poderá gerenciar usuários aqui.
                </div>
            </div>
        </div>
    </article>

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

        // Fechar alertas automaticamente após 5 segundos
        document.addEventListener('DOMContentLoaded', function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                setTimeout(() => {
                    const bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                }, 5000);
            });
        });
    </script>
</body>
</html>