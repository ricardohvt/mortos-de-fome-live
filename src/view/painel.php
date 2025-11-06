<?php
session_start();

if (!isset($_SESSION['user']['isAdmin']) || $_SESSION['user']['isAdmin'] != 1) {
    header("Location: ./login-index.php");
    die;
}

include_once '../service/conexao.php';
$conexao = instance2();

// Buscar categorias
$categorias = [];
$sql_categorias = "SELECT * FROM categoria_post";
$result_categorias = $conexao->query($sql_categorias);
if ($result_categorias && $result_categorias->num_rows > 0) {
    while ($row = $result_categorias->fetch_assoc()) {
        $categorias[] = $row;
    }
}

// Buscar posts
$posts = [];
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
$conexao->close();

// Contar categorias no PHP
$categoriaCount = [];
foreach ($posts as $post) {
    $cat = $post['descricao_categoria'] ?? 'Sem categoria';
    $categoriaCount[$cat] = ($categoriaCount[$cat] ?? 0) + 1;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mortos de Fome - Painel</title>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- Seu CSS -->
    <link rel="stylesheet" href="style/painel-style.css">
    <link rel="icon" href="assets/marsal.png" type="image/png">
</head>
<body>

<article class="page-main">
    <!-- Sidebar -->
    <div class="Seila">
        <section class="nav-aside">
            <div class="side">
                <a class="navbar-brand" href="#"><img src="assets/logo.png" alt="Logo"></a>
            </div>
            <div class="side active" data-tab="dashboard">
                <a href="?tab=dashboard"><i class="fas fa-home"></i> Dashboard</a>
            </div>
            <div class="side" data-tab="postagens">
                <a href="?tab=postagens"><i class="fas fa-utensils"></i> Postagens</a>
            </div>
            <div class="side" data-tab="usuarios">
                <a href="?tab=usuarios"><i class="fas fa-users"></i> Usuários</a>
            </div>
            <div class="side btn-down-logout">
                <a href="../model/LogoutModel.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
            </div>
        </section>
    </div>

    <!-- Conteúdo Principal -->
    <div class="main-content">

        <?php 
        $currentTab = $_GET['tab'] ?? 'dashboard';
        $validTabs = ['dashboard', 'postagens', 'usuarios'];
        $currentTab = in_array($currentTab, $validTabs) ? $currentTab : 'dashboard';
        ?>

        <!-- ==================================== DASHBOARD ==================================== -->
        <div class="tab-content" id="dashboard" style="display: <?php echo $currentTab === 'dashboard' ? 'block' : 'none'; ?>;">
            <div class="content-adm">

                <h1 class="section-title">Dashboard</h1>

                <?php if (isset($_SESSION['success'])): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <?php if (isset($_SESSION['error'])): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <div class="stats-grid">
                    <div class="stat-card">
                        <i class="fas fa-utensils"></i>
                        <h3><?php echo count($posts); ?></h3>
                        <p>Total de Receitas</p>
                    </div>
                    <div class="stat-card">
                        <i class="fas fa-clock"></i>
                        <h3><?php echo count(array_filter($posts, fn($p) => $p['autorizado'] == 0)); ?></h3>
                        <p>Pendentes</p>
                    </div>
                    <div class="stat-card">
                        <i class="fas fa-check-circle"></i>
                        <h3><?php echo count(array_filter($posts, fn($p) => $p['autorizado'] == 1)); ?></h3>
                        <p>Aprovadas</p>
                    </div>
                    <div class="stat-card">
                        <i class="fas fa-users"></i>
                        <h3>--</h3>
                        <p>Usuários Ativos</p>
                    </div>
                </div>

                <!-- BOTÃO CORRIGIDO: ADICIONADO O # -->
    

                <h2 class="section-title">Últimas Receitas</h2>
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>Título</th>
                                <th>Categoria</th>
                                <th>Data</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $recentes = array_slice($posts, 0, 5);
                            foreach ($recentes as $post): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($post['nome_post']); ?></td>
                                <td><?php echo htmlspecialchars($post['descricao_categoria'] ?? 'Sem categoria'); ?></td>
                                <td><?php echo date('d/m/Y', strtotime($post['criado_em'])); ?></td>
                                <td>
                                    <span class="<?php echo $post['autorizado'] ? 'status-aprovado' : 'status-pendente'; ?>">
                                        <?php echo $post['autorizado'] ? 'Aprovado' : 'Pendente'; ?>
                                    </span>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                            <?php if (empty($recentes)): ?>
                            <tr>
                                <td colspan="4" style="text-align:center; padding:20px; color:#999;">
                                    Nenhuma receita encontrada.
                                </td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <h2 class="section-title">Receitas por Categoria</h2>
                <div class="chart-container">
                    <canvas id="categoryChart"></canvas>
                </div>

            </div>
        </div>

        <!-- ==================================== POSTAGENS =================================== -->
        <div class="tab-content" id="postagens" style="display: <?php echo $currentTab === 'postagens' ? 'block' : 'none'; ?>;">
            <div class="content">
                <div class="welcome"><p>Área de Postagem</p></div>

                <!-- BOTÃO NA ABA POSTAGENS TAMBÉM CORRIGIDO -->
                <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#CriarPostagemModal">
                    Criar Nova Postagem
                </button>

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
                                        <form action="../controller/PostActionController.php" method="POST" class="d-inline">
                                            <input type="hidden" name="postID" value="<?php echo $post['postID']; ?>">
                                            <?php if ($post['autorizado']): ?>
                                                <button name="action" value="revogar" class="btn btn-sm btn-warning">Revogar</button>
                                            <?php else: ?>
                                                <button name="action" value="aprovar" class="btn btn-sm btn-success">Aprovar</button>
                                            <?php endif; ?>
                                        </form>

                                        <button class="btn btn-sm btn-primary" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#editarPostModal"
                                            data-id="<?php echo $post['postID']; ?>"
                                            data-titulo="<?php echo htmlspecialchars($post['nome_post']); ?>"
                                            data-ingredientes="<?php echo htmlspecialchars($post['ingredientes'] ?? ''); ?>"
                                            data-modo="<?php echo htmlspecialchars($post['modoPreparo'] ?? ''); ?>"
                                            data-categoria="<?php echo $post['categoria_postID']; ?>">
                                            Editar
                                        </button>

                                        <form action="../controller/PostActionController.php" method="POST" class="d-inline" onsubmit="return confirm('Excluir este post?');">
                                            <input type="hidden" name="postID" value="<?php echo $post['postID']; ?>">
                                            <button name="action" value="excluir" class="btn btn-sm btn-danger">Excluir</button>
                                        </form>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- ==================================== USUÁRIOS ==================================== -->
        <div class="tab-content" id="usuarios" style="display: <?php echo $currentTab === 'usuarios' ? 'block' : 'none'; ?>;">
            <div class="welcome"><p>Gerenciamento de Usuários</p></div>
            <div class="alert alert-info">Funcionalidade em desenvolvimento.</div>
        </div>
    </div>
</article>

<!-- MODAL DE CRIAR POSTAGEM (ID CORRETO) -->
<div class="modal fade" id="CriarPostagemModal" tabindex="-1" aria-labelledby="CriarPostagemModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="CriarPostagemModalLabel">Nova Receita</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form action="../controller/PainelController.php" method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label class="form-label">Título da Receita *</label>
                        <input type="text" class="form-control" name="nome-receita" required maxlength="255">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Categoria *</label>
                        <select class="form-select" name="categoria-receita" required>
                            <option value="">Selecione uma categoria</option>
                            <?php foreach ($categorias as $categoria): ?>
                            <option value="<?php echo $categoria['categoria_postID']; ?>">
                                <?php echo htmlspecialchars($categoria['descricao_categoria']); ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Ingredientes *</label>
                        <textarea class="form-control" name="ingredientes-receita" required rows="4"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Modo de Preparo *</label>
                        <textarea class="form-control" name="modo-receita" required rows="6"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Imagens</label>
                        <input type="file" class="form-control" name="imagens-receita[]" multiple accept="image/*">
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">Postar Receita</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Estilos -->
<style>
    .status-aprovado, .status-pendente {
        padding: 6px 12px; border-radius: 20px; font-size: 0.8rem; font-weight: 600; color: white; display: inline-block;
    }
    .status-aprovado { background: #4caf50 !important; }
    .status-pendente { background: #ff9800 !important; }
</style>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Navegação por abas
        document.querySelectorAll('.side[data-tab] a').forEach(link => {
            link.addEventListener('click', function(e) {
                const tab = this.closest('.side').getAttribute('data-tab');
                document.querySelectorAll('.tab-content').forEach(t => t.style.display = 'none');
                document.getElementById(tab).style.display = 'block';
                document.querySelectorAll('.side').forEach(s => s.classList.remove('active'));
                this.closest('.side').classList.add('active');
            });
        });

        // Gráfico
        const ctx = document.getElementById('categoryChart')?.getContext('2d');
        if (ctx) {
            const labels = <?php echo json_encode(array_keys($categoriaCount)); ?>;
            const data = <?php echo json_encode(array_values($categoriaCount)); ?>;

            new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: labels.length ? labels : ['Sem Dados'],
                    datasets: [{
                        data: data.length ? data : [1],
                        backgroundColor: labels.length ? ['#eb4a4a', '#ff7961', '#ff9e80', '#ffb74d', '#ffd180'] : ['#ccc'],
                        borderWidth: 2,
                        borderColor: '#fff'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { position: 'bottom' } }
                }
            });
        }
    });
</script>

</body>
</html>