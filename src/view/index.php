<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Mortos de Fome</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
    integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,200;1,14..32,200&family=Itim&family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&display=swap"
    rel="stylesheet">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,200;1,14..32,200&family=Itim&family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&display=swap"
    rel="stylesheet">
  <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
  <link rel="stylesheet" href="style/index-style.css">
  <link rel="icon" href="assets/marsal.png" type="image/png">
</head>

<body>
  <nav class="navbar navbar-expand-lg ">
    <div class="container-fluid position-relative">
      <a class="navbar-brand" href="index.php">
        <img src="assets/logo.png"
          alt="Logo"> </a>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="index.php"><i class="fa-solid fa-house"></i></a>
          </li>
          <li class="nav-item">
            </a>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
              <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item dropdown">
                  <a id="navpal" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                    aria-expanded="false">
                    Menu
                  </a>
                  <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="#">Receitas</a></li>
                    <li><a class="dropdown-item" onclick="mostrarconversor()">Conversor de medidas</a></li>
                    <li><a class="dropdown-item" href="upload-post-index.php">Postar</a></li>
                  </ul>
                </li>
                <li class="nav-item-1">
                  <?php
                  session_start();

                  if (isset($_SESSION['user'])) {
                    $username = $_SESSION['user']['username'];
                    $isAdmin = $_SESSION['user']['isAdmin'] ?? 0;
                    $link = $isAdmin == 1 ? 'painel.php' : 'painel-usuario.php';

                    echo "<a class='login' href='$link'>
          Você está logado, $username!
        </a>";
                  } else {
                    echo "<a class='login' href='login-index.php'>
          Login
        </a>";
                  }
                  ?>


                </li>
              </ul>
            </div>

            <div class="icons-main-centered">
              <div class="plant-container">
                <a href="vegetariano-vegano.php"><img src="assets/image 3.png" height="30px"></a>
              </div>
              <div class="zero-lactose-container">
                <a href="zero-lactose.php"><img src="assets/zero-lactose.svg" height="30px"></a>
              </div>
              <div class="zero-gluten-container">
                <a href="zero-gluten.php"><img src="assets/zero-gluten.svg" height="30px" width="30px"></a>
              </div>
              <div class="zero-sugar-container">
                <a href="zero-acucar.php"><img src="assets/zero-sugar.svg" height="30px" width="30px"></a>
              </div>
              <div class="fit-container">
                <a href="fitness.php"><img src="assets/fit.svg" height="30px" width="30px"></a>
              </div>
            </div>
      </div>
  </nav>
  <aside id="conversor">
    <div class="conversor-content">
      <div class="form-group">
        <label for="quantity">Quantidade:</label>
        <input type="number" name="quantity" id="quantity" placeholder="Quantidade" class="input">
      </div>

      <div class="form-group">
        <label for="unit_from">De:</label>
        <select name="unit_from" id="unit_from" class="input">
          <option value="g">Gramas (g)</option>
          <option value="kg">Quilogramas (kg)</option>
          <option value="lb">Libras (lb)</option>
          <option value="oz">Onças (oz)</option>
          <option value="ml">Mililitros (ml)</option>
          <option value="l">Litros (l)</option>
          <option value="colher_de_cha">Colheres de chá</option>
          <option value="colher_de_sopa">Colheres de sopa</option>
          <option value="xicara">Xícaras</option>
        </select>
      </div>

      <div class="form-group">
        <label for="unit_to">Para:</label>
        <select name="unit_to" id="unit_to" class="input">
          <option value="g">Gramas (g)</option>
          <option value="kg">Quilogramas (kg)</option>
          <option value="lb">Libras (lb)</option>
          <option value="oz">Onças (oz)</option>
          <option value="ml">Mililitros (ml)</option>
          <option value="l">Litros (l)</option>
          <option value="colher_de_cha">Colheres de chá</option>
          <option value="colher_de_sopa">Colheres de sopa</option>
          <option value="xicara">Xícaras</option>
        </select>
      </div>

      <div class="btn-container">
        <button onclick="convertUnits()" class="btn-1">Converter</button>
        <button onclick="fecharconversor()" class="btn-1">Fechar</button>
      </div>

      <div id="result"></div>
    </div>
  </aside>
  <div class="search">
    <form class="d-flex" role="search" method="GET" action="search.php">
      <input class="form-control me-2" type="search" placeholder="Busque uma receita ou ingredientes"
        aria-label="Search" name="q" required>
      <button class="btn btn-outline-secondary decosearch" type="submit" id="input-search"><i
          class="fa-solid fa-magnifying-glass"></i></button>
    </form>
  </div>
  <div><!--carrossel-->
    <div id="carouselExampleFade" class="carousel slide carousel-fade">
      <div class="carousel-inner">
        <div class="carousel-item active caro1">
          <img src="assets/background.webp" class="d-block w-100">
          <h1 class="abertura">Bem vindo ao Mortos de Fome</h1>
          <h2 class="abertura-2">
            Aproveite nossas receitas!
          </h2>
        </div>
        <div class="carousel-item caro1">
          <img src="assets/tortademaca.jpg" class="d-block w-100">
          <h1 class="abertura">Receitas vegetarianas e sem glútem</h1>
        </div>
        <div class="carousel-item caro1">
          <img src="assets/comidafitness.jpg" class="d-block w-100">
          <h1 class="abertura">Receitas apetitosas e saúdaveis</h1>
        </div>
      </div>
      <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleFade" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Anterior</span>
      </button>
      <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleFade" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Próximo</span>
      </button>
    </div>
</div><!--carrossel-end-->

  <?php
  require_once '../service/conexao.php';
  $con = instance2();
  $cats = [];
  $r = $con->query("SELECT categoria_postID, descricao_categoria FROM categoria_post ORDER BY descricao_categoria");
  if ($r && $r->num_rows > 0) { while ($row = $r->fetch_assoc()) { $cats[] = $row; } }

  // Carregar posts autorizados por categoria (até 8 por categoria)
  $byCat = [];
  foreach ($cats as $c) {
    $cid = intval($c['categoria_postID']);
    $items = [];
    $res = $con->query("SELECT postID, nome_post, criado_em FROM post WHERE autorizado=1 AND categoria_postID={$cid} ORDER BY criado_em DESC LIMIT 8");
    while ($res && ($p = $res->fetch_assoc())) {
      // pegar 1a imagem
      $stmt = $con->prepare('SELECT image FROM post_images WHERE PostID=? ORDER BY post_imagesID ASC LIMIT 1');
      $pid = intval($p['postID']);
      $stmt->bind_param('i', $pid);
      $stmt->execute();
      $stmt->store_result();
      $img = null;
      if ($stmt->num_rows > 0) { $stmt->bind_result($imgData); $stmt->fetch(); $img = 'data:image/jpeg;base64,' . base64_encode($imgData); }
      $stmt->close();
      $p['img'] = $img;
      $items[] = $p;
    }
    $byCat[$cid] = $items;
  }
  $con->close();
  ?>

  <?php
  // Novas queries: posts aleatórios e "Pratos Principais" COM PAGINAÇÃO
  require_once '../service/conexao.php';
  $con2 = instance2();

  $postsPerPage = 3; // Receitas por página (ALTERADO DE 6 PARA 3)
  
  // Obter página atual (GET parameter)
  $pagePratos = isset($_GET['page_pratos']) ? max(1, intval($_GET['page_pratos'])) : 1;
  $pageAleatorios = isset($_GET['page_aleatorios']) ? max(1, intval($_GET['page_aleatorios'])) : 1;

  // ===== PRATOS PRINCIPAIS =====
  $pratosPrincipais = [];
  $totalPratos = 0;
  $ppId = null;
  
  foreach ($cats as $c) {
    if (mb_strtolower(trim($c['descricao_categoria']), 'UTF-8') === 'pratos principais') {
      $ppId = intval($c['categoria_postID']);
      break;
    }
  }

  if ($ppId !== null) {
    // Contar total de pratos
    $countRes = $con2->query("SELECT COUNT(*) as total FROM post WHERE autorizado=1 AND categoria_postID={$ppId}");
    $countRow = $countRes->fetch_assoc();
    $totalPratos = intval($countRow['total']);
    
    // Calcular offset
    $offsetPratos = ($pagePratos - 1) * $postsPerPage;
    
    // Buscar pratos da página atual
    $res = $con2->query("SELECT postID, nome_post, descricao_post, criado_em FROM post WHERE autorizado=1 AND categoria_postID={$ppId} ORDER BY criado_em DESC LIMIT {$postsPerPage} OFFSET {$offsetPratos}");
    while ($res && ($p = $res->fetch_assoc())) {
      $stmt = $con2->prepare('SELECT image FROM post_images WHERE PostID=? ORDER BY post_imagesID ASC LIMIT 1');
      $pid = intval($p['postID']);
      $stmt->bind_param('i', $pid);
      $stmt->execute();
      $stmt->store_result();
      $img = null;
      if ($stmt->num_rows > 0) { $stmt->bind_result($imgData); $stmt->fetch(); $img = 'data:image/jpeg;base64,' . base64_encode($imgData); }
      $stmt->close();
      $p['img'] = $img;
      
      // contar likes
      $stmtLikes = $con2->prepare('SELECT COUNT(*) as total_likes FROM user_likes WHERE postID=?');
      $stmtLikes->bind_param('i', $pid);
      $stmtLikes->execute();
      $stmtLikes->bind_result($likesCount);
      $stmtLikes->fetch();
      $stmtLikes->close();
      $p['likes'] = $likesCount ?? 0;
      
      $pratosPrincipais[] = $p;
    }
  }
  
  $totalPagesPratos = ceil($totalPratos / $postsPerPage);

  // ===== POSTS ALEATÓRIOS =====
  $randomPosts = [];
  $totalAleatorios = 0;
  
  // Contar total de posts aleatórios
  $countRes = $con2->query("SELECT COUNT(*) as total FROM post WHERE autorizado=1");
  $countRow = $countRes->fetch_assoc();
  $totalAleatorios = intval($countRow['total']);
  
  // Calcular offset
  $offsetAleatorios = ($pageAleatorios - 1) * $postsPerPage;
  
  // Buscar posts da página atual
  $r = $con2->query("SELECT postID, nome_post, descricao_post, criado_em, categoria_postID FROM post WHERE autorizado=1 ORDER BY RAND() LIMIT {$postsPerPage} OFFSET {$offsetAleatorios}");
  if ($r && $r->num_rows > 0) {
    while ($p = $r->fetch_assoc()) {
      $stmt = $con2->prepare('SELECT image FROM post_images WHERE PostID=? ORDER BY post_imagesID ASC LIMIT 1');
      $pid = intval($p['postID']);
      $stmt->bind_param('i', $pid);
      $stmt->execute();
      $stmt->store_result();
      $img = null;
      if ($stmt->num_rows > 0) { $stmt->bind_result($imgData); $stmt->fetch(); $img = 'data:image/jpeg;base64,' . base64_encode($imgData); }
      $stmt->close();
      $p['img'] = $img;
      
      $stmtLikes = $con2->prepare('SELECT COUNT(*) as total_likes FROM user_likes WHERE postID=?');
      $stmtLikes->bind_param('i', $pid);
      $stmtLikes->execute();
      $stmtLikes->bind_result($likesCount);
      $stmtLikes->fetch();
      $stmtLikes->close();
      $p['likes'] = $likesCount ?? 0;
      
      $randomPosts[] = $p;
    }
  }
  
  $totalPagesAleatorios = ceil($totalAleatorios / $postsPerPage);
  $con2->close();
?>

  <section class="container my-5">
    <h1 class="rec-title" data-aos="fade-up">Receitas</h1>

    <!-- Pratos Principais -->
    <div id="pratos-principais" class="mt-4">
      <h2 class="mb-3">Pratos Principais</h2>

      <?php if (empty($pratosPrincipais)): ?>
        <p class="text-muted">Sem receitas em "Pratos Principais" no momento.</p>
      <?php else: ?>
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-3 g-3 justify-content-center">
          <?php foreach ($pratosPrincipais as $p): ?>
            <div class="col">
              <a href="post.php?id=<?php echo intval($p['postID']); ?>" class="text-decoration-none text-reset">
                <div class="card h-100 shadow-sm position-relative">
                  <?php if (!empty($p['img'])): ?>
                    <img src="<?php echo $p['img']; ?>" class="card-img-top" alt="Imagem da receita">
                  <?php else: ?>
                    <img src="assets/logo.png" class="card-img-top" alt="Sem imagem">
                  <?php endif; ?>
                  <div class="card-body d-flex flex-column justify-content-between">
                    <div>
                      <h5 class="card-title"><?php echo htmlspecialchars($p['nome_post']); ?></h5>
                      <p class="card-text text-muted small" style="line-height: 1.4;">
                        <?php echo htmlspecialchars(substr($p['descricao_post'] ?? '', 0, 80)); ?>
                        <?php if (strlen($p['descricao_post'] ?? '') > 80): ?>...<?php endif; ?>
                      </p>
                    </div>
                    <div class="d-flex justify-content-between align-items-end mt-2">
                      <p class="card-text text-muted mb-0 small"><i class="fa-regular fa-calendar"></i> <?php echo date('d/m/Y', strtotime($p['criado_em'])); ?></p>
                      <div style="background: rgba(255,255,255,0.9); border-radius: 8px; padding: 0.25rem 0.5rem;">
                        <i class="fa-solid fa-heart" style="color: #ff4757;"></i> <span><?php echo intval($p['likes']); ?></span>
                      </div>
                    </div>
                  </div>
                </div>
              </a>
            </div>
          <?php endforeach; ?>
        </div>
        
        <!-- Paginação Pratos Principais -->
        <?php if ($totalPagesPratos > 1): ?>
          <nav aria-label="Paginação Pratos Principais" class="mt-4">
            <ul class="pagination justify-content-center">
              <!-- <li class="page-item <?php echo ($pagePratos <= 1) ? 'disabled' : ''; ?>">
                <a class="page-link" href="<?php echo ($pagePratos > 1) ? '?page_pratos=1#pratos-principais' : '#'; ?>">Primeira</a>
              </li> -->
              <li class="page-item <?php echo ($pagePratos <= 1) ? 'disabled' : ''; ?>">
                <a class="page-link" href="<?php echo ($pagePratos > 1) ? '?page_pratos=' . ($pagePratos - 1) . '#pratos-principais' : '#'; ?>">Anterior</a>
              </li>
              
              <?php for ($i = 1; $i <= $totalPagesPratos; $i++): ?>
                <li class="page-item <?php echo ($i === $pagePratos) ? 'active' : ''; ?>">
                  <a class="page-link" href="?page_pratos=<?php echo $i; ?>#pratos-principais"><?php echo $i; ?></a>
                </li>
              <?php endfor; ?>
              
              <li class="page-item <?php echo ($pagePratos >= $totalPagesPratos) ? 'disabled' : ''; ?>">
                <a class="page-link" href="<?php echo ($pagePratos < $totalPagesPratos) ? '?page_pratos=' . ($pagePratos + 1) . '#pratos-principais' : '#'; ?>">Próxima</a>
              </li>
              <!-- <li class="page-item <?php echo ($pagePratos >= $totalPagesPratos) ? 'disabled' : ''; ?>">
                <a class="page-link" href="<?php echo ($pagePratos < $totalPagesPratos) ? '?page_pratos=' . $totalPagesPratos . '#pratos-principais' : '#'; ?>">Última</a>
              </li> -->
            </ul>
          </nav>
        <?php endif; ?>
      <?php endif; ?>
    </div>

    <!-- Aleatórios -->
    <div id="aleatorios" class="mt-5">
      <h2 class="mb-3">Aleatórios</h2>

      <?php if (empty($randomPosts)): ?>
        <p class="text-muted">Nenhuma receita aleatória encontrada.</p>
      <?php else: ?>
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-3 g-3 justify-content-center">
          <?php foreach ($randomPosts as $p): ?>
            <div class="col">
              <a href="post.php?id=<?php echo intval($p['postID']); ?>" class="text-decoration-none text-reset">
                <div class="card h-100 shadow-sm position-relative">
                  <?php if (!empty($p['img'])): ?>
                    <img src="<?php echo $p['img']; ?>" class="card-img-top" alt="Imagem da receita">
                  <?php else: ?>
                    <img src="assets/logo.png" class="card-img-top" alt="Sem imagem">
                  <?php endif; ?>
                  <div class="card-body d-flex flex-column justify-content-between">
                    <div>
                      <h5 class="card-title"><?php echo htmlspecialchars($p['nome_post']); ?></h5>
                      <p class="card-text text-muted small" style="line-height: 1.4;">
                        <?php echo htmlspecialchars(substr($p['descricao_post'] ?? '', 0, 80)); ?>
                        <?php if (strlen($p['descricao_post'] ?? '') > 80): ?>...<?php endif; ?>
                      </p>
                    </div>
                    <div class="d-flex justify-content-between align-items-end mt-2">
                      <p class="card-text text-muted mb-0 small"><i class="fa-regular fa-calendar"></i> <?php echo date('d/m/Y', strtotime($p['criado_em'])); ?></p>
                      <div style="background: rgba(255,255,255,0.9); border-radius: 8px; padding: 0.25rem 0.5rem;">
                        <i class="fa-solid fa-heart" style="color: #ff4757;"></i> <span><?php echo intval($p['likes']); ?></span>
                      </div>
                    </div>
                  </div>
                </div>
              </a>
            </div>
          <?php endforeach; ?>
        </div>
        
        <!-- Paginação Aleatórios -->
        <?php if ($totalPagesAleatorios > 1): ?>
          <nav aria-label="Paginação Aleatórios" class="mt-4">
            <ul class="pagination justify-content-center">
              <!-- <li class="page-item <?php echo ($pageAleatorios <= 1) ? 'disabled' : ''; ?>">
                <a class="page-link" href="<?php echo ($pageAleatorios > 1) ? '?page_aleatorios=1#aleatorios' : '#'; ?>">Primeira</a>
              </li> -->
              <li class="page-item <?php echo ($pageAleatorios <= 1) ? 'disabled' : ''; ?>">
                <a class="page-link" href="<?php echo ($pageAleatorios > 1) ? '?page_aleatorios=' . ($pageAleatorios - 1) . '#aleatorios' : '#'; ?>">Anterior</a>
              </li>
              
              <?php for ($i = 1; $i <= $totalPagesAleatorios; $i++): ?>
                <li class="page-item <?php echo ($i === $pageAleatorios) ? 'active' : ''; ?>">
                  <a class="page-link" href="?page_aleatorios=<?php echo $i; ?>#aleatorios"><?php echo $i; ?></a>
                </li>
              <?php endfor; ?>
              
              <li class="page-item <?php echo ($pageAleatorios >= $totalPagesAleatorios) ? 'disabled' : ''; ?>">
                <a class="page-link" href="<?php echo ($pageAleatorios < $totalPagesAleatorios) ? '?page_aleatorios=' . ($pageAleatorios + 1) . '#aleatorios' : '#'; ?>">Próxima</a>
              </li>
              <!-- <li class="page-item <?php echo ($pageAleatorios >= $totalPagesAleatorios) ? 'disabled' : ''; ?>">
                <a class="page-link" href="<?php echo ($pageAleatorios < $totalPagesAleatorios) ? '?page_aleatorios=' . $totalPagesAleatorios . '#aleatorios' : '#'; ?>">Última</a>
              </li> -->
            </ul>
          </nav>
        <?php endif; ?>
      <?php endif; ?>
    </div>
  </section>

  <footer class="footer" data-aos="fade-up">
    <div class="footer-container">
      <div class="footer-top">
        <div>
          <img src="assets/logo.png" alt="Mortos de fome" class="footer-title" height="100px">
          <ul class="footer-list">
            <li class="footer-list-item">
              <a href="#" class="footer-list-link">Sobre</a>
            </li>
            <li class="footer-list-item">
              <a href="#" class="footer-list-link">Receitas</a>
            </li>
            <li class="footer-list-item">
              <a href="#" class="footer-list-link">Afiliados</a>
            </li>
            <li>
              <a href=""><span class="copyright">2024 Mortos de fome. Todos os direitos reservados.</span></a>
            </li>
          </ul>
        </div>
        <div>
          <hr class="footer-divider">
        </div>
  </footer>

  <script src="javascript/script.js"></script>
  <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
  <script>
    AOS.init();
  </script>
</body>

</html>