<?php
session_start();

if (!isset($_SESSION["user"]["isAdmin"]) || $_SESSION["user"]["isAdmin"] != 1) {
    header("Location: ./login-index.php");
    die();
}

include_once "../service/conexao.php";
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

// Contagem total de usuários (para o dashboard)
$usersCountTotal = 0;
$res_ct = $conexao->query("SELECT COUNT(*) AS c FROM `user`");
if ($res_ct && $res_ct->num_rows > 0) {
    $usersCountTotal = (int) $res_ct->fetch_assoc()["c"];
}

// Filtros da tela de usuários
$u_q = trim($_GET["u_q"] ?? "");
$u_admin = $_GET["u_admin"] ?? "";
$whereParts = [];
if ($u_q !== "") {
    $qEsc = $conexao->real_escape_string($u_q);
    $whereParts[] = "(username LIKE '%$qEsc%' OR email LIKE '%$qEsc%')";
}
if ($u_admin === "0" || $u_admin === "1") {
    $whereParts[] = "COALESCE(isAdmin,0) = " . ($u_admin === "1" ? "1" : "0");
}
$whereSql = count($whereParts) ? " WHERE " . implode(" AND ", $whereParts) : "";

// Buscar usuários (aplicando filtros)
$users = [];
$sql_users =
    "SELECT userID, username, email, COALESCE(isAdmin, 0) AS isAdmin FROM `user`" .
    $whereSql .
    " ORDER BY userID DESC";
$result_users = $conexao->query($sql_users);
if ($result_users && $result_users->num_rows > 0) {
    while ($row = $result_users->fetch_assoc()) {
        $users[] = $row;
    }
}

$conexao->close();

// Contar categorias no PHP
$categoriaCount = [];
foreach ($posts as $post) {
    $cat = $post["descricao_categoria"] ?? "Sem categoria";
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
        $currentTab = $_GET["tab"] ?? "dashboard";
        $validTabs = ["dashboard", "postagens", "usuarios"];
        $currentTab = in_array($currentTab, $validTabs)
            ? $currentTab
            : "dashboard";
        ?>

        <!-- ==================================== DASHBOARD ==================================== -->
        <div class="tab-content" id="dashboard" style="display: <?php echo $currentTab ===
        "dashboard"
            ? "block"
            : "none"; ?>;">
            <div class="content-adm">

                <h1 class="section-title">Dashboard</h1>

                <?php if (isset($_SESSION["success"])): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <?php
                        echo $_SESSION["success"];
                        unset($_SESSION["success"]);
                        ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <?php if (isset($_SESSION["error"])): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <?php
                        echo $_SESSION["error"];
                        unset($_SESSION["error"]);
                        ?>
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
                        <h3><?php echo count(
                            array_filter(
                                $posts,
                                fn($p) => $p["autorizado"] == 0,
                            ),
                        ); ?></h3>
                        <p>Pendentes</p>
                    </div>
                    <div class="stat-card">
                        <i class="fas fa-check-circle"></i>
                        <h3><?php echo count(
                            array_filter(
                                $posts,
                                fn($p) => $p["autorizado"] == 1,
                            ),
                        ); ?></h3>
                        <p>Aprovadas</p>
                    </div>
                    <div class="stat-card">
                        <i class="fas fa-users"></i>
                        <h3><?php echo isset($usersCountTotal)
                            ? $usersCountTotal
                            : 0; ?></h3>
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
                                <td><?php echo htmlspecialchars(
                                    $post["nome_post"],
                                ); ?></td>
                                <td><?php echo htmlspecialchars(
                                    $post["descricao_categoria"] ??
                                        "Sem categoria",
                                ); ?></td>
                                <td><?php echo date(
                                    "d/m/Y",
                                    strtotime($post["criado_em"]),
                                ); ?></td>
                                <td>
                                    <span class="<?php echo $post["autorizado"]
                                        ? "status-aprovado"
                                        : "status-pendente"; ?>">
                                        <?php echo $post["autorizado"]
                                            ? "Aprovado"
                                            : "Pendente"; ?>
                                    </span>
                                </td>
                            </tr>
                            <?php endforeach;
                            ?>
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
        <div class="tab-content" id="postagens" style="display: <?php echo $currentTab ===
        "postagens"
            ? "block"
            : "none"; ?>;">
            <div class="content">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div class="welcome"><p>Área de Postagem</p></div>
                    <div class="d-flex gap-2">
                        <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#modalCreateCategory">
                            <i class="fa fa-folder-plus me-1"></i> Nova Categoria
                        </button>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#CriarPostagemModal">
                            Criar Nova Postagem
                        </button>
                    </div>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-12 col-lg-4">
                        <div class="card h-100">
                            <div class="card-header">Categorias</div>
                            <div class="card-body p-0">
                                <table class="table mb-0 table-sm align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Nome</th>
                                            <th class="text-end">Ações</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (empty($categorias)): ?>
                                            <tr><td colspan="2" class="text-muted text-center py-3">Nenhuma categoria.</td></tr>
                                        <?php else:foreach (
                                                $categorias
                                                as $c
                                            ): ?>
                                            <tr>
                                                <td><?php echo htmlspecialchars(
                                                    $c["descricao_categoria"],
                                                ); ?></td>
                                                <td class="text-end">
                                                    <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#modalRenameCategory" data-id="<?php echo $c[
                                                        "categoria_postID"
                                                    ]; ?>" data-name="<?php echo htmlspecialchars(
    $c["descricao_categoria"],
); ?>">Renomear</button>
                                                </td>
                                            </tr>
                                        <?php endforeach;endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-8">
                        <div class="posts-list">
                            <h4>Posts Existentes</h4>
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
                                    <td><?php echo htmlspecialchars(
                                        $post["nome_post"],
                                    ); ?></td>
                                    <td><?php echo htmlspecialchars(
                                        $post["descricao_categoria"] ??
                                            "Sem categoria",
                                    ); ?></td>
                                    <td><?php echo date(
                                        "d/m/Y H:i",
                                        strtotime($post["criado_em"]),
                                    ); ?></td>
                                    <td>
                                        <span class="badge <?php echo $post[
                                            "autorizado"
                                        ]
                                            ? "bg-success"
                                            : "bg-warning"; ?>">
                                            <?php echo $post["autorizado"]
                                                ? "Aprovado"
                                                : "Pendente"; ?>
                                        </span>
                                    </td>
                                    <td>
                                        <form action="../controller/PostActionController.php" method="POST" class="d-inline">
                                            <input type="hidden" name="postID" value="<?php echo $post[
                                                "postID"
                                            ]; ?>">
                                            <?php if ($post["autorizado"]): ?>
                                                <button name="action" value="revogar" class="btn btn-sm btn-warning">Revogar</button>
                                            <?php else: ?>
                                                <button name="action" value="aprovar" class="btn btn-sm btn-success">Aprovar</button>
                                            <?php endif; ?>
                                        </form>

                                        <button class="btn btn-sm btn-primary"
                                            data-bs-toggle="modal"
                                            data-bs-target="#editarPostModal"
                                            data-id="<?php echo $post[
                                                "postID"
                                            ]; ?>"
                                            data-titulo="<?php echo htmlspecialchars(
                                                $post["nome_post"],
                                            ); ?>"
data-ingredientes="<?php echo htmlspecialchars($post['ingredients'] ?? '', ENT_QUOTES); ?>"
                                            data-modo="<?php echo htmlspecialchars(
                                                $post["modoPreparo"] ?? "",
                                            ); ?>"
                                            data-categoria="<?php echo $post[
                                                "categoria_postID"
                                            ]; ?>">
                                            Editar
                                        </button>

                                        <form action="../controller/PostActionController.php" method="POST" class="d-inline" onsubmit="return confirm('Excluir este post?');">
                                            <input type="hidden" name="postID" value="<?php echo $post[
                                                "postID"
                                            ]; ?>">
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
            </div>
        </div>

        <!-- ==================================== USUÁRIOS ==================================== -->
        <div class="tab-content" id="usuarios" style="display: <?php echo $currentTab ===
        "usuarios"
            ? "block"
            : "none"; ?>;">
            <div class="content">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div class="welcome"><p>Gerenciamento de Usuários</p></div>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalCreateUser">
                        <i class="fa fa-user-plus me-1"></i> Novo Usuário
                    </button>
                </div>

                <?php if (isset($_SESSION["success"])): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <?php
                        echo $_SESSION["success"];
                        unset($_SESSION["success"]);
                        ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>
                <?php if (isset($_SESSION["error"])): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <?php
                        echo $_SESSION["error"];
                        unset($_SESSION["error"]);
                        ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <form method="GET" class="row g-2 align-items-end mb-3">
                    <input type="hidden" name="tab" value="usuarios" />
                    <div class="col-sm-6 col-md-5">
                        <label class="form-label">Buscar (nome ou e-mail)</label>
                        <input type="text" name="u_q" class="form-control" placeholder="ex.: maria, maria@site.com" value="<?php echo htmlspecialchars(
                            $u_q ?? "",
                        ); ?>" />
                    </div>
                    <div class="col-sm-4 col-md-3">
                        <label class="form-label">Perfil</label>
                        <select name="u_admin" class="form-select">
                            <option value="" <?php echo $u_admin === ""
                                ? "selected"
                                : ""; ?>>Todos</option>
                            <option value="1" <?php echo $u_admin === "1"
                                ? "selected"
                                : ""; ?>>Apenas Admins</option>
                            <option value="0" <?php echo $u_admin === "0"
                                ? "selected"
                                : ""; ?>>Apenas Usuários</option>
                        </select>
                    </div>
                    <div class="col-sm-2 col-md-4">
                        <button type="submit" class="btn btn-primary me-2"><i class="fa fa-filter me-1"></i> Filtrar</button>
                        <a href="?tab=usuarios" class="btn btn-outline-secondary">Limpar</a>
                    </div>
                </form>

                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Nome de usuário</th>
                                <th>E-mail</th>
                                <th class="text-center">Admin</th>
                                <th class="text-end">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php if (!empty($users)): ?>
                            <?php foreach ($users as $u): ?>
                                <tr>
                                    <td>#<?php echo intval(
                                        $u["userID"],
                                    ); ?></td>
                                    <td><?php echo htmlspecialchars(
                                        $u["username"],
                                    ); ?></td>
                                    <td><?php echo htmlspecialchars(
                                        $u["email"],
                                    ); ?></td>
                                    <td class="text-center">
                                        <span class="badge <?php echo intval(
                                            $u["isAdmin"],
                                        )
                                            ? "bg-success"
                                            : "bg-secondary"; ?>">
                                            <?php echo intval($u["isAdmin"])
                                                ? "Sim"
                                                : "Não"; ?>
                                        </span>
                                    </td>
                                    <td class="text-end">
                                        <button
                                            class="btn btn-sm btn-outline-primary me-1"
                                            data-bs-toggle="modal"
                                            data-bs-target="#modalEditUser"
                                            data-userid="<?php echo intval(
                                                $u["userID"],
                                            ); ?>"
                                            data-username="<?php echo htmlspecialchars(
                                                $u["username"],
                                            ); ?>"
                                            data-email="<?php echo htmlspecialchars(
                                                $u["email"],
                                            ); ?>"
                                            data-isadmin="<?php echo intval(
                                                $u["isAdmin"],
                                            ); ?>">
                                            <i class="fa fa-edit"></i> Editar
                                        </button>
                                        <form action="../controller/UserActionController.php" method="POST" class="d-inline" onsubmit="return confirm('Excluir este usuário? Esta ação é irreversível.');">
                                            <input type="hidden" name="action" value="delete">
                                            <input type="hidden" name="userID" value="<?php echo intval(
                                                $u["userID"],
                                            ); ?>">
                                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                                <i class="fa fa-trash"></i> Excluir
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">Nenhum usuário encontrado.</td>
                            </tr>
                        <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
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
                        <label class="form-label">Descrição *</label>
                        <textarea class="form-control" name="descricao-receita" required rows="3" maxlength="500" placeholder="Descrição breve da receita (até 500 caracteres)"></textarea>
                        <small class="text-muted d-block mt-1">
                            <span id="descricaoCount">0</span>/500 caracteres
                        </small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Categoria *</label>
                        <select class="form-select" name="categoria-receita" required>
                            <option value="">Selecione uma categoria</option>
                            <?php foreach ($categorias as $categoria): ?>
                            <option value="<?php echo $categoria[
                                "categoria_postID"
                            ]; ?>">
                                <?php echo htmlspecialchars(
                                    $categoria["descricao_categoria"],
                                ); ?>
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

<!-- MODAL: Criar Categoria -->
<div class="modal fade" id="modalCreateCategory" tabindex="-1" aria-labelledby="modalCreateCategoryLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalCreateCategoryLabel">Nova Categoria</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <form action="../controller/CategoryActionController.php" method="POST">
        <input type="hidden" name="action" value="create" />
        <div class="modal-body">
          <label class="form-label">Nome da categoria</label>
          <input type="text" class="form-control" name="descricao_categoria" required maxlength="255" placeholder="Ex.: Vegetariano, Zero Gluten" />
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-primary">Criar</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- MODAL: Renomear Categoria -->
<div class="modal fade" id="modalRenameCategory" tabindex="-1" aria-labelledby="modalRenameCategoryLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalRenameCategoryLabel">Renomear Categoria</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <form action="../controller/CategoryActionController.php" method="POST">
        <input type="hidden" name="action" value="rename" />
        <input type="hidden" name="categoria_postID" id="renameCategoriaID" />
        <div class="modal-body">
          <label class="form-label">Novo nome</label>
          <input type="text" class="form-control" name="descricao_categoria" id="renameCategoriaNome" required maxlength="255" />
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-primary">Salvar</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- MODAL: Criar Usuário -->
<div class="modal fade" id="modalCreateUser" tabindex="-1" aria-labelledby="modalCreateUserLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalCreateUserLabel">Novo Usuário</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <form action="../controller/UserActionController.php" method="POST">
        <input type="hidden" name="action" value="create">
        <div class="modal-body">
            <div class="mb-3">
                <label class="form-label">Nome completo (opcional)</label>
                <input type="text" class="form-control" name="full_name" maxlength="255">
            </div>
            <div class="mb-3">
                <label class="form-label">Nome de usuário *</label>
                <input type="text" class="form-control" name="username" required maxlength="120">
            </div>
            <div class="mb-3">
                <label class="form-label">E-mail *</label>
                <input type="email" class="form-control" name="email" required maxlength="255">
            </div>
            <div class="mb-3">
                <label class="form-label">Senha *</label>
                <input type="password" class="form-control" name="password" required minlength="6">
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="createIsAdmin" name="isAdmin" value="1">
                <label class="form-check-label" for="createIsAdmin">Conceder acesso de Admin</label>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn btn-primary">Criar</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- MODAL: Editar Usuário -->
<div class="modal fade" id="modalEditUser" tabindex="-1" aria-labelledby="modalEditUserLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalEditUserLabel">Editar Usuário</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <form action="../controller/UserActionController.php" method="POST">
        <input type="hidden" name="action" value="update">
        <input type="hidden" name="userID" id="editUserID">
        <div class="modal-body">
            <div class="mb-3">
                <label class="form-label">Nome de usuário *</label>
                <input type="text" class="form-control" name="username" id="editUsername" required maxlength="120">
            </div>
            <div class="mb-3">
                <label class="form-label">E-mail *</label>
                <input type="email" class="form-control" name="email" id="editEmail" required maxlength="255">
            </div>
            <div class="mb-3">
                <label class="form-label">Nova senha (opcional)</label>
                <input type="password" class="form-control" name="password" id="editPassword" minlength="6" placeholder="Deixe em branco para manter a atual">
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="editIsAdmin" name="isAdmin" value="1">
                <label class="form-check-label" for="editIsAdmin">Administrador</label>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn btn-primary">Salvar</button>
        </div>
      </form>
    </div>
</div>
</div>

<!-- MODAL: Editar Postagem -->
<div class="modal fade" id="editarPostModal" tabindex="-1" aria-labelledby="editarPostModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editarPostModalLabel">Editar Postagem</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <form action="../controller/PostActionController.php" method="POST">
        <input type="hidden" name="action" value="editar">
        <input type="hidden" name="postID" id="editarPostID">
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label">Título</label>
            <input type="text" class="form-control" name="nome_post" id="editarTitulo" required maxlength="255">
          </div>
          <div class="mb-3">
            <label class="form-label">Descrição</label>
            <textarea class="form-control" name="descricao_post" id="editarDescricao" rows="3" maxlength="500" placeholder="Descrição breve da receita (até 500 caracteres)"></textarea>
            <small class="text-muted d-block mt-1">
              <span id="editarDescricaoCount">0</span>/500 caracteres
            </small>
          </div>
          <div class="mb-3">
            <label class="form-label">Categoria</label>
            <select class="form-select" name="categoria_postID" id="editarCategoria" required>
              <?php foreach ($categorias as $categoria): ?>
              <option value="<?php echo $categoria[
                  "categoria_postID"
              ]; ?>"><?php echo htmlspecialchars(
    $categoria["descricao_categoria"],
); ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label">Ingredientes</label>
            <textarea class="form-control" name="ingredientes" id="editarIngredientes" rows="4" required></textarea>
          </div>
          <div class="mb-3">
            <label class="form-label">Modo de Preparo</label>
            <textarea class="form-control" name="modoPreparo" id="editarModo" rows="6" required></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-primary">Salvar alterações</button>
        </div>
      </form>

      <div class="modal-body border-top">
        <h6>Imagens</h6>
        <div id="editarImagensList" class="d-flex flex-wrap gap-2 mb-2"></div>
        <form id="formAddImgs" action="../controller/PostImageController.php" method="POST" enctype="multipart/form-data" class="d-flex gap-2 align-items-center">
          <input type="hidden" name="action" value="add">
          <input type="hidden" name="postID" id="editarImgsPostID">
          <input type="hidden" name="redirect" value="../view/painel.php?tab=postagens">
          <input type="file" name="images[]" accept="image/*" multiple class="form-control form-control-sm"/>
          <button type="submit" class="btn btn-sm btn-outline-primary">Adicionar imagens</button>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
  document.addEventListener('DOMContentLoaded', function() {
    // Navegação por abas (sem recarregar)
    document.querySelectorAll('.side[data-tab] a').forEach(link => {
      link.addEventListener('click', function(e) {
        e.preventDefault();
        const tab = this.closest('.side').getAttribute('data-tab');
        document.querySelectorAll('.tab-content').forEach(t => t.style.display = 'none');
        const el = document.getElementById(tab);
        if (el) el.style.display = 'block';
        document.querySelectorAll('.side').forEach(s => s.classList.remove('active'));
        this.closest('.side').classList.add('active');
      });
    });

    // Modal: Editar Usuário
    const editUserModal = document.getElementById('modalEditUser');
    editUserModal?.addEventListener('show.bs.modal', (event) => {
      const btn = event.relatedTarget;
      document.getElementById('editUserID').value = btn.getAttribute('data-userid');
      document.getElementById('editUsername').value = btn.getAttribute('data-username') || '';
      document.getElementById('editEmail').value = btn.getAttribute('data-email') || '';
      document.getElementById('editPassword').value = '';
      document.getElementById('editIsAdmin').checked = parseInt(btn.getAttribute('data-isadmin') || '0', 10) === 1;
    });

    // Modal: Renomear Categoria
    const modalRenameCategory = document.getElementById('modalRenameCategory');
    modalRenameCategory?.addEventListener('show.bs.modal', (event) => {
      const btn = event.relatedTarget;
      document.getElementById('renameCategoriaID').value = btn.getAttribute('data-id');
      document.getElementById('renameCategoriaNome').value = btn.getAttribute('data-name') || '';
    });

    // Contador de caracteres para descrição ao criar
    const descricaoCreateInput = document.querySelector('#CriarPostagemModal textarea[name="descricao-receita"]');
    if (descricaoCreateInput) {
      descricaoCreateInput.addEventListener('input', function() {
        document.getElementById('descricaoCount').textContent = this.value.length;
      });
    }

    // Contador de caracteres para descrição ao editar
    const descricaoEditInput = document.getElementById('editarDescricao');
    if (descricaoEditInput) {
      descricaoEditInput.addEventListener('input', function() {
        document.getElementById('editarDescricaoCount').textContent = this.value.length;
      });
    }

    // Modal: Editar Post (preencher + imagens)
    const editarPostModal = document.getElementById('editarPostModal');
    editarPostModal?.addEventListener('show.bs.modal', async function (event) {
      const button = event.relatedTarget;
      const pid = button.getAttribute('data-id') || '';
      document.getElementById('editarPostID').value = pid;
      document.getElementById('editarTitulo').value = button.getAttribute('data-titulo') || '';
      document.getElementById('editarDescricao').value = button.getAttribute('data-descricao') || '';
      document.getElementById('editarDescricaoCount').textContent = button.getAttribute('data-descricao')?.length || 0;
      document.getElementById('editarIngredientes').value = button.getAttribute('data-ingredientes') || '';
      document.getElementById('editarModo').value = button.getAttribute('data-modo') || '';
      const cat = button.getAttribute('data-categoria') || '';
      const sel = document.getElementById('editarCategoria');
      if (sel) sel.value = cat;

      // Carregar imagens
      document.getElementById('editarImgsPostID').value = pid;
      const list = document.getElementById('editarImagensList');
      list.innerHTML = '<span class="text-muted">Carregando imagens...</span>';
      try {
        const resp = await fetch(`../controller/PostImageController.php?action=list&postID=${pid}`);
        const data = await resp.json();
        if (!data.ok) throw new Error();
        list.innerHTML = '';
        data.items.forEach(img => {
          const wrap = document.createElement('div');
          wrap.className = 'img-thumb position-relative';
          wrap.innerHTML = `
            <img src="${img.b64}" class="rounded border w-100 h-100" style="object-fit:cover;"/>
            <form action="../controller/PostImageController.php" method="POST" class="position-absolute" style="top:6px; right:6px;">
              <input type="hidden" name="action" value="delete" />
              <input type="hidden" name="post_imagesID" value="${img.id}" />
              <input type="hidden" name="redirect" value="../view/painel.php?tab=postagens" />
              <button class="btn btn-sm btn-danger rounded-circle p-0" style="width:24px;height:24px;line-height:20px;" title="Remover" onclick="return confirm('Remover esta imagem?')">&times;</button>
            </form>`;
          list.appendChild(wrap);
        });
      } catch (e) {
        list.innerHTML = '<span class="text-danger">Falha ao carregar imagens.</span>';
      }
    });

    // Chart categorias
    const ctx = document.getElementById('categoryChart')?.getContext('2d');
    if (ctx) {
      const labels = <?php echo json_encode(array_keys($categoriaCount)); ?>;
      const data = <?php echo json_encode(array_values($categoriaCount)); ?>;
      new Chart(ctx, {
        type: 'doughnut',
        data: { labels: labels.length ? labels : ['Sem Dados'], datasets: [{ data: data.length ? data : [1], backgroundColor: labels.length ? ['#eb4a4a', '#ff7961', '#ff9e80', '#ffb74d', '#ffd180'] : ['#ccc'], borderWidth: 2, borderColor: '#fff' }] },
        options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { position: 'bottom' } } }
      });
    }
  });
</script>
</body>
</html>
