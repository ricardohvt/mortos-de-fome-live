<?php
session_start();


if (!isset($_SESSION['user'])) {
    $_SESSION['login_error'] = "Faça o login para acessar o Painel de usuário!";
    header("Location: ./login-index.php");
    die;
}

include_once '../service/conexao.php';
$conexao = instance2();




$userPosts = [];
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


$categorias = [];
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
    <title>Mortos de Fome - Painel do Usuário</title>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https:
    <!-- Bootstrap -->
    <link href="https:
    
    <!-- IMPORTANTE: Usando o CSS do Admin para manter o mesmo visual -->
    <link rel="stylesheet" href="style/painel-style.css">
    <link rel="icon" href="assets/marsal.png" type="image/png">
</head>
<body>

<article class="page-main">
    <!-- Sidebar (Cópia fiel do Admin, mas com links do Usuário) -->
    <div class="Seila">
        <section class="nav-aside">
            <div class="side">
                <a class="navbar-brand" href="index.php"><img src="assets/logo.png" alt="Logo"></a>
            </div>
            
            <!-- Link Dashboard -->
            <div class="side active" data-tab="dashboard">
                <a href="#" onclick="return false;"><i class="fas fa-home"></i> Dashboard</a>
            </div>
            
            <!-- Link Minhas Receitas -->
            <div class="side" data-tab="postagens">
                <a href="#" onclick="return false;"><i class="fas fa-utensils"></i> Minhas Receitas</a>
            </div>
            
            <!-- Link Nova Receita -->
            <div class="side" data-tab="nova-postagem">
                <a href="#" onclick="return false;"><i class="fas fa-plus-circle"></i> Criar Receita</a>
            </div>

            <!-- Logout -->
            <div class="side btn-down-logout">
                <a href="../model/LogoutModel.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
            </div>
        </section>
    </div>

    <!-- Conteúdo Principal -->
    <div class="main-content">

        <!-- ==================================== DASHBOARD ==================================== -->
        <div class="tab-content" id="dashboard" style="display: block;">
            <div class="content-adm">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h1 class="section-title mb-0">Dashboard</h1>
                    <span class="text-muted">Olá, <?php echo htmlspecialchars($_SESSION['user']['username']); ?>!</span>
                </div>

                <!-- Cards de Estatísticas (Estilo Admin) -->
                <div class="stats-grid">
                    <div class="stat-card">
                        <i class="fas fa-book-open"></i>
                        <h3><?php echo count($userPosts); ?></h3>
                        <p>Total de Receitas</p>
                    </div>
                    <div class="stat-card">
                        <i class="fas fa-check-circle"></i>
                        <h3><?php echo count(array_filter($userPosts, fn($p) => $p['autorizado'] == 1)); ?></h3>
                        <p>Publicadas</p>
                    </div>
                    <div class="stat-card">
                        <i class="fas fa-hourglass-half"></i>
                        <h3><?php echo count(array_filter($userPosts, fn($p) => $p['autorizado'] == 0)); ?></h3>
                        <p>Em Análise</p>
                    </div>
                </div>

                <!-- Tabela de Resumo -->
                <h2 class="section-title mt-5">Minhas Últimas Receitas</h2>
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
                            $recentes = array_slice($userPosts, 0, 5);
                            if(empty($recentes)): ?>
                                <tr><td colspan="4" class="text-center p-3">Você ainda não tem receitas.</td></tr>
                            <?php else: 
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
                            <?php endforeach; endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- ==================================== MINHAS POSTAGENS ==================================== -->
        <div class="tab-content" id="postagens" style="display: none;">
            <div class="content-adm">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h1 class="section-title mb-0">Gerenciar Receitas</h1>
                    <!-- Botão atalho para ir para aba de criar -->
                    <button class="btn btn-primary" onclick="document.querySelector('[data-tab=\'nova-postagem\'] a').click()">
                        <i class="fa fa-plus me-1"></i> Nova Receita
                    </button>
                </div>

                <div class="table-container">
                    <table class="table table-striped align-middle">
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
                            <?php if (empty($userPosts)): ?>
                                <tr><td colspan="5" class="text-center p-4">Nenhuma receita encontrada.</td></tr>
                            <?php else: foreach ($userPosts as $post): ?>
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
                                    <!-- Botão Editar -->
                                    <button class="btn btn-sm btn-outline-primary me-1" 
                                        data-bs-toggle="modal"
                                        data-bs-target="#editarPostUserModal"
                                        data-id="<?php echo $post['postID']; ?>"
                                        data-titulo="<?php echo htmlspecialchars($post['nome_post'], ENT_QUOTES); ?>"
                                        data-descricao="<?php echo htmlspecialchars($post['descricao_post'] ?? '', ENT_QUOTES); ?>"
                                        data-ingredientes="<?php echo htmlspecialchars($post['ingredients'] ?? '', ENT_QUOTES); ?>"
                                        data-modo="<?php echo htmlspecialchars($post['modoPreparo'] ?? '', ENT_QUOTES); ?>"
                                        data-categoria="<?php echo $post['categoria_postID']; ?>">
                                        <i class="fa fa-edit"></i>
                                    </button>

                                    <!-- Botão Excluir -->
                                    <form action="../controller/UserPostActionController.php" method="POST" class="d-inline" onsubmit="return confirm('Tem certeza que deseja excluir esta receita?');">
                                        <input type="hidden" name="action" value="excluir" />
                                        <input type="hidden" name="postID" value="<?php echo $post['postID']; ?>" />
                                        <button class="btn btn-sm btn-outline-danger"><i class="fa fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                            <?php endforeach; endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- ==================================== NOVA POSTAGEM ==================================== -->
        <div class="tab-content" id="nova-postagem" style="display: none;">
            <div class="content-adm">
                <h1 class="section-title">Criar Nova Receita</h1>
                
                <div class="card shadow-sm border-0">
                    <div class="card-body p-4">
                        <form action="../controller/PostController.php" method="POST" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-8 mb-3">
                                    <label class="form-label fw-bold">Título da Receita *</label>
                                    <input type="text" class="form-control" name="nome-receita" required maxlength="255">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label fw-bold">Categoria *</label>
                                    <select class="form-select" name="categoria-receita" required>
                                        <option value="">Selecione...</option>
                                        <?php foreach ($categorias as $categoria): ?>
                                        <option value="<?php echo $categoria['categoria_postID']; ?>">
                                            <?php echo htmlspecialchars($categoria['descricao_categoria']); ?>
                                        </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Descrição Curta</label>
                                <textarea class="form-control" name="descricao-receita" rows="2" maxlength="500" placeholder="Uma breve apresentação do prato..."></textarea>
                                <small class="text-muted d-block mt-1 text-end"><span id="descricaoCount">0</span>/500</small>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Ingredientes *</label>
                                <textarea class="form-control" name="ingredientes-receita" rows="5" required placeholder="Ex:&#10;- 2 xícaras de farinha&#10;- 3 ovos"></textarea>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Modo de Preparo *</label>
                                <textarea class="form-control" name="modo-receita" rows="6" required placeholder="Descreva o passo a passo detalhadamente..."></textarea>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Imagens</label>
                                <input type="file" class="form-control" name="imagens-receita[]" multiple accept="image/*">
                                <div class="form-text">Formatos: JPG, PNG. Máx: 5MB.</div>
                            </div>

                            <div class="d-grid d-md-flex justify-content-md-end">
                                <button type="submit" class="btn btn-primary px-5">
                                    <i class="fa fa-paper-plane me-2"></i> Enviar para Aprovação
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</article>

<!-- MODAL: Editar Post (Versão do Usuário) -->
<div class="modal fade" id="editarPostUserModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Editar Minha Receita</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <form action="../controller/UserPostActionController.php" method="POST">
        <input type="hidden" name="action" value="editar">
        <input type="hidden" name="postID" id="uEditarPostID">
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label">Título</label>
            <input type="text" class="form-control" name="nome_post" id="uEditarTitulo" required maxlength="255">
          </div>
          <div class="mb-3">
            <label class="form-label">Descrição</label>
            <textarea class="form-control" name="descricao_post" id="uEditarDescricao" rows="2" maxlength="500"></textarea>
          </div>
          <div class="mb-3">
            <label class="form-label">Categoria</label>
            <select class="form-select" name="categoria_postID" id="uEditarCategoria" required>
              <?php foreach ($categorias as $categoria): ?>
              <option value="<?php echo $categoria['categoria_postID']; ?>"><?php echo htmlspecialchars($categoria['descricao_categoria']); ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label">Ingredientes</label>
            <textarea class="form-control" name="ingredientes" id="uEditarIngredientes" rows="4" required></textarea>
          </div>
          <div class="mb-3">
            <label class="form-label">Modo de Preparo</label>
            <textarea class="form-control" name="modoPreparo" id="uEditarModo" rows="6" required></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-primary">Salvar alterações</button>
        </div>
      </form>

      <!-- Área de Gerenciar Imagens no Modal -->
      <div class="modal-body border-top bg-light">
        <h6 class="mb-3">Gerenciar Imagens</h6>
        <div id="uEditarImagensList" class="d-flex flex-wrap gap-2 mb-3"></div>
        
        <form id="uFormAddImgs" action="../controller/PostImageController.php" method="POST" enctype="multipart/form-data" class="d-flex gap-2 align-items-center">
          <input type="hidden" name="action" value="add">
          <input type="hidden" name="postID" id="uEditarImgsPostID">
          <!-- Redirecionar de volta para a aba postagens do usuário -->
          <input type="hidden" name="redirect" value="../view/painel-usuario.php?tab=postagens">
          <input type="file" name="images[]" accept="image/*" multiple class="form-control form-control-sm"/>
          <button type="submit" class="btn btn-sm btn-outline-primary">Adicionar</button>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Scripts (Bootstrap + Lógica das Abas e Modal) -->
<script src="https:
<script>
document.addEventListener('DOMContentLoaded', function() {
    
    const sideLinks = document.querySelectorAll('.side[data-tab]');
    const tabs = document.querySelectorAll('.tab-content');
    const sideDivs = document.querySelectorAll('.side');

    function switchTab(targetId) {
        
        tabs.forEach(tab => tab.style.display = 'none');
        sideDivs.forEach(div => div.classList.remove('active'));
        
        
        const targetTab = document.getElementById(targetId);
        if (targetTab) targetTab.style.display = 'block';
        
        
        const activeLink = document.querySelector(`.side[data-tab="${targetId}"]`);
        if (activeLink) activeLink.classList.add('active');
        
        
        const url = new URL(window.location);
        url.searchParams.set('tab', targetId);
        window.history.pushState({}, '', url);
    }

    
    sideLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const target = this.getAttribute('data-tab');
            switchTab(target);
        });
    });

    
    const params = new URLSearchParams(window.location.search);
    const currentTab = params.get('tab');
    if (currentTab && document.getElementById(currentTab)) {
        switchTab(currentTab);
    }

    
    const descInput = document.querySelector('textarea[name="descricao-receita"]');
    const descCount = document.getElementById('descricaoCount');
    if (descInput && descCount) {
        descInput.addEventListener('input', function() {
            descCount.textContent = this.value.length;
        });
    }

    
    const uModal = document.getElementById('editarPostUserModal');
    uModal?.addEventListener('show.bs.modal', async (event) => {
        const btn = event.relatedTarget;
        const pid = btn.getAttribute('data-id');
        
        
        document.getElementById('uEditarPostID').value = pid;
        document.getElementById('uEditarTitulo').value = btn.getAttribute('data-titulo') || '';
        document.getElementById('uEditarDescricao').value = btn.getAttribute('data-descricao') || '';
        document.getElementById('uEditarIngredientes').value = btn.getAttribute('data-ingredientes') || '';
        document.getElementById('uEditarModo').value = btn.getAttribute('data-modo') || '';
        
        const cat = btn.getAttribute('data-categoria') || '';
        const sel = document.getElementById('uEditarCategoria');
        if (sel) sel.value = cat;

        
        document.getElementById('uEditarImgsPostID').value = pid;

        
        const list = document.getElementById('uEditarImagensList');
        list.innerHTML = '<span class="text-muted small">Carregando imagens...</span>';
        
        try {
            const resp = await fetch(`../controller/PostImageController.php?action=list&postID=${pid}`);
            const data = await resp.json();
            
            list.innerHTML = ''; 
            
            if (data.ok && Array.isArray(data.items)) {
                if(data.items.length === 0) {
                    list.innerHTML = '<span class="text-muted small">Sem imagens cadastradas.</span>';
                }
                
                data.items.forEach(img => {
                    const wrap = document.createElement('div');
                    wrap.className = 'position-relative border rounded';
                    wrap.style.width = '80px';
                    wrap.style.height = '80px';
                    wrap.style.overflow = 'hidden';
                    
                    wrap.innerHTML = `
                        <img src="${img.b64}" class="w-100 h-100" style="object-fit:cover;"/>
                        <form action="../controller/PostImageController.php" method="POST" class="position-absolute top-0 end-0 m-1">
                            <input type="hidden" name="action" value="delete" />
                            <input type="hidden" name="post_imagesID" value="${img.id}" />
                            <input type="hidden" name="redirect" value="../view/painel-usuario.php?tab=postagens" />
                            <button class="btn btn-sm btn-danger p-0 d-flex align-items-center justify-content-center" 
                                    style="width:20px;height:20px;font-size:12px;" 
                                    title="Remover" onclick="return confirm('Remover?')">
                                <i class="fa fa-times"></i>
                            </button>
                        </form>`;
                    list.appendChild(wrap);
                });
            } else {
                 throw new Error();
            }
        } catch(e) {
            list.innerHTML = '<span class="text-danger small">Erro ao carregar imagens.</span>';
        }
    });
});
</script>
</body>
</html>