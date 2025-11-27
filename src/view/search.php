<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Buscar receitas - Mortos de Fome</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="style/index-style.css">
</head>
<body>
<div class="container my-4">
  <a href="index.php" class="btn btn-sm btn-secondary mb-3">← Voltar</a>

  <?php
  // ...existing code...
  require_once '../service/conexao.php';
  $q = isset($_GET['q']) ? trim($_GET['q']) : '';

  if ($q === '') {
    echo '<div class="alert alert-warning">Por favor informe um termo para busca.</div>';
    exit;
  }

  $con = instance2();

  // Busca em nome_post e descricao_post apenas posts autorizados
  $sql = "SELECT postID, nome_post, descricao_post, criado_em FROM post WHERE autorizado = 1 AND (nome_post LIKE ? OR descricao_post LIKE ?) ORDER BY criado_em DESC LIMIT 50";
  $stmt = $con->prepare($sql);
  $like = '%' . $q . '%';
  $stmt->bind_param('ss', $like, $like);
  $stmt->execute();

  // get_result() funciona quando mysqli com mysqlnd está habilitado
  $res = $stmt->get_result();
  $rows = $res ? $res->fetch_all(MYSQLI_ASSOC) : [];

  echo '<h3>Resultados para: <small class="text-muted">' . htmlspecialchars($q) . '</small></h3>';

  if (empty($rows)) {
    echo '<p class="text-muted">Nenhuma receita encontrada.</p>';
    $stmt->close();
    $con->close();
    exit;
  }

  echo '<div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3 mt-3">';

  foreach ($rows as $p) {
    $pid = intval($p['postID']);
    // pegar 1ª imagem
    $img = null;
    $stmtImg = $con->prepare('SELECT image FROM post_images WHERE PostID=? ORDER BY post_imagesID ASC LIMIT 1');
    $stmtImg->bind_param('i', $pid);
    $stmtImg->execute();
    $stmtImg->store_result();
    if ($stmtImg->num_rows > 0) {
      $stmtImg->bind_result($imgData);
      $stmtImg->fetch();
      $img = 'data:image/jpeg;base64,' . base64_encode($imgData);
    }
    $stmtImg->close();

    // contar likes
    $likes = 0;
    $stmtLikes = $con->prepare('SELECT COUNT(*) as total_likes FROM user_likes WHERE postID=?');
    $stmtLikes->bind_param('i', $pid);
    $stmtLikes->execute();
    $stmtLikes->bind_result($likesCount);
    $stmtLikes->fetch();
    $stmtLikes->close();
    $likes = intval($likesCount ?? 0);

    // render card
    echo '<div class="col">';
    echo '<a href="post.php?id=' . $pid . '" class="text-decoration-none text-reset">';
    echo '<div class="card h-100 shadow-sm">';
    if ($img) {
      echo '<img src="' . $img . '" class="card-img-top" alt="Imagem da receita">';
    } else {
      echo '<img src="assets/logo.png" class="card-img-top" alt="Sem imagem">';
    }
    echo '<div class="card-body d-flex flex-column justify-content-between">';
    echo '<div><h5 class="card-title">' . htmlspecialchars($p['nome_post']) . '</h5>';
    $desc = htmlspecialchars(substr($p['descricao_post'] ?? '', 0, 120));
    echo '<p class="card-text text-muted small" style="line-height:1.3;">' . $desc;
    if (strlen($p['descricao_post'] ?? '') > 120) echo '...';
    echo '</p></div>';
    echo '<div class="d-flex justify-content-between align-items-end mt-2">';
    echo '<p class="card-text text-muted mb-0 small"><i class="fa-regular fa-calendar"></i> ' . date('d/m/Y', strtotime($p['criado_em'])) . '</p>';
    echo '<div style="background: rgba(255,255,255,0.9); border-radius:8px; padding:0.25rem 0.5rem;"><i class="fa-solid fa-heart" style="color:#ff4757;"></i> <span>' . $likes . '</span></div>';
    echo '</div></div></div></a></div>';
  }

  echo '</div>'; // row

  $stmt->close();
  $con->close();
  ?>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"></script>
</body>
</html>