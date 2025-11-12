<?php
session_start();
require_once "../service/conexao.php";

$con = instance2();

$postID = isset($_GET["id"]) ? intval($_GET["id"]) : 0;
$post = null;
$imgB64 = null;
$likes = 0;
$favs = 0;
$comments = [];
$likedByMe = false;
$favoritedByMe = false;

if ($postID > 0) {
    // Buscar post autorizado + autor + categoria
    $stmt = $con->prepare(
        "SELECT p.*, u.username, c.descricao_categoria FROM post p LEFT JOIN user u ON u.userID=p.userID LEFT JOIN categoria_post c ON c.categoria_postID=p.categoria_postID WHERE p.postID=? AND p.autorizado=1",
    );
    $stmt->bind_param("i", $postID);
    $stmt->execute();
    $res = $stmt->get_result();
    if ($res && $res->num_rows > 0) {
        $post = $res->fetch_assoc();
    }
    $stmt->close();

    if ($post) {
        // Imagem principal (primeira)
        $stmt = $con->prepare(
            "SELECT image FROM post_images WHERE PostID=? ORDER BY post_imagesID ASC LIMIT 1",
        );
        $stmt->bind_param("i", $postID);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            $stmt->bind_result($imgData);
            $stmt->fetch();
            if (!is_null($imgData)) {
                $imgB64 = "data:image/jpeg;base64," . base64_encode($imgData);
            }
        }
        $stmt->close();

        // Contagens
        $q = $con->query(
            "SELECT COUNT(*) c FROM user_likes WHERE postID=" . $postID,
        );
        if ($q) {
            $likes = intval($q->fetch_assoc()["c"]);
        }
        $q = $con->query(
            "SELECT COUNT(*) c FROM user_favoritos WHERE postID=" . $postID,
        );
        if ($q) {
            $favs = intval($q->fetch_assoc()["c"]);
        }

        // Comentários
        $stmt = $con->prepare(
            "SELECT cp.*, u.username FROM comentarios_post cp JOIN user u ON u.userID=cp.userID WHERE cp.postID=? ORDER BY cp.comentarios_postID ASC",
        );
        $stmt->bind_param("i", $postID);
        $stmt->execute();
        $res = $stmt->get_result();
        while ($res && ($row = $res->fetch_assoc())) {
            $comments[] = $row;
        }
        $stmt->close();

        if (isset($_SESSION["user"]["userID"])) {
            $uid = intval($_SESSION["user"]["userID"]);
            $stmt = $con->prepare(
                "SELECT 1 FROM user_likes WHERE userID=? AND postID=?",
            );
            $stmt->bind_param("ii", $uid, $postID);
            $stmt->execute();
            $stmt->store_result();
            $likedByMe = $stmt->num_rows > 0;
            $stmt->close();
            $stmt = $con->prepare(
                "SELECT 1 FROM user_favoritos WHERE userID=? AND postID=?",
            );
            $stmt->bind_param("ii", $uid, $postID);
            $stmt->execute();
            $stmt->store_result();
            $favoritedByMe = $stmt->num_rows > 0;
            $stmt->close();
        }
    }
}

$con->close();
?>
<!DOCTYPE html>
<html lang="pt-br">

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
                  <?php if (isset($_SESSION["user"])) {
                      $username = $_SESSION["user"]["username"];
                      $isAdmin = $_SESSION["user"]["isAdmin"] ?? 0;
                      $link =
                          $isAdmin == 1 ? "painel.php" : "painel-usuario.php";

                      echo "<a class='login' href='$link'>
          Você está logado, $username!
        </a>";
                  } else {
                      echo "<a class='login' href='login-index.php'>
          Login
        </a>";
                  } ?>


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

  <main class="container my-4">
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

    <?php if (!$post): ?>
      <div class="alert alert-warning">Post não encontrado ou não autorizado.</div>
    <?php else: ?>
      <div class="row g-4" style="
    display: flex;
    flex-direction: column;
    align-items: center;
">
        <div class="col-12 col-md-5">
          <div class="card shadow-sm">
            <?php if ($imgB64): ?>
              <img class="imagem-post" src="<?php echo $imgB64; ?>" class="card-img-top" alt="Imagem da receita">
            <?php else: ?>
<img src="assets/logo.png" class="card-img-top" alt="Sem imagem">
            <?php endif; ?>

          </div>
          <h2 class="mb-1"><?php echo htmlspecialchars(
              $post["nome_post"],
          ); ?></h2>
          <p class="text-muted mb-2">
            <i class="fa-regular fa-folder"></i> <?php echo htmlspecialchars(
                $post["descricao_categoria"] ?? "",
            ); ?>
            &nbsp;•&nbsp;
            <i class="fa-regular fa-user"></i> <?php echo htmlspecialchars(
                $post["username"] ?? "",
            ); ?>
            &nbsp;•&nbsp;
            <i class="fa-regular fa-calendar"></i> <?php echo date(
                "d/m/Y H:i",
                strtotime($post["criado_em"]),
            ); ?>
          </p>

          <div class="mb-3">
            <?php if (isset($_SESSION["user"]["userID"])): ?>
              <form class="d-inline" action="../controller/InteractController.php" method="POST">
                <input type="hidden" name="action" value="like">
                <input type="hidden" name="postID" value="<?php echo $postID; ?>">
                <button type="submit" class="btn btn-sm <?php echo $likedByMe
                    ? "btn-danger"
                    : "btn-outline-danger"; ?> me-2">
                  <i class="fa-regular fa-heart"></i> Curtir (<?php echo $likes; ?>)
                </button>
              </form>
              <form class="d-inline" action="../controller/InteractController.php" method="POST">
                <input type="hidden" name="action" value="favorite">
                <input type="hidden" name="postID" value="<?php echo $postID; ?>">
                <button type="submit" class="btn btn-sm <?php echo $favoritedByMe
                    ? "btn-warning"
                    : "btn-outline-warning"; ?>">
                  <i class="fa-regular fa-star"></i> Favoritar (<?php echo $favs; ?>)
                </button>
              </form>
            <?php else: ?>
              <a class="btn btn-sm btn-outline-danger me-2 disabled"><i class="fa-regular fa-heart"></i> Curtir (<?php echo $likes; ?>)</a>
              <a class="btn btn-sm btn-outline-warning disabled"><i class="fa-regular fa-star"></i> Favoritar (<?php echo $favs; ?>)</a>
              <small class="text-muted ms-2">Entre para curtir e favoritar.</small>
            <?php endif; ?>
          </div>
        </div>
        <div class="col-12 col-md-7 coluna">

          <div class="mb-4">
            <h5>Ingredientes</h5>
            <div class="border rounded p-3 bg-light" style="white-space:pre-wrap;">
              <?php echo nl2br(htmlspecialchars($post["ingredients"])); ?>
            </div>
          </div>

          <div class="mb-4">
            <h5>Modo de Preparo</h5>
            <div class="border rounded p-3" style="white-space:pre-wrap;">
              <?php echo nl2br(htmlspecialchars($post["modoPreparo"])); ?>
            </div>
          </div>
        </div>
      </div>

      <hr class="my-4"/>

      <section class="mt-3">
        <h4 class="mb-3">Comentários</h4>
        <?php if (empty($comments)): ?>
          <p class="text-muted">Seja o primeiro a comentar.</p>
        <?php else: ?>
          <ul class="list-group mb-3">
            <?php foreach ($comments as $c): ?>
              <li class="list-group-item">
                <strong><?php echo htmlspecialchars(
                    $c["username"],
                ); ?>:</strong>
                <div style="white-space:pre-wrap;" class="mt-1"><?php echo nl2br(
                    htmlspecialchars($c["comentario"]),
                ); ?></div>
              </li>
            <?php endforeach; ?>
          </ul>
        <?php endif; ?>

        <?php if (isset($_SESSION["user"]["userID"])): ?>
          <form action="../controller/CommentController.php" method="POST" class="card card-body">
            <input type="hidden" name="postID" value="<?php echo $postID; ?>" />
            <div class="mb-2">
              <label class="form-label">Escreva um comentário</label>
              <textarea name="comentario" class="form-control" rows="3" required maxlength="2000"></textarea>
            </div>
            <div>
              <button type="submit" class="btn btn-primary">Publicar</button>
            </div>
          </form>
        <?php else: ?>
          <div class="alert alert-info">Faça <a href="login-index.php">login</a> para comentar.</div>
        <?php endif; ?>
      </section>
    <?php endif; ?>
  </main>

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
