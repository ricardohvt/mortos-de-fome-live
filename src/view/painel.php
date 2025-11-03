<<<<<<< Updated upstream
=======
<?php
session_start();

if (!isset($_SESSION['user']['isAdmin']) || $_SESSION['user']['isAdmin'] != 1) {
  header("Location: ./login-index.php");
  die;
}
?>


>>>>>>> Stashed changes
<!DOCTYPE html>
<html lang="en">

<head>

  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
    <link rel="icon" href="assets/marsal.png" type="image/png">
    <link rel="stylesheet" href="style/painel-style.css">
  </head>
  <title>Mortos de Fome - Painel</title>
</head>
<<<<<<< Updated upstream
<article class="page-main">
  <div class="Seila">
    <section class="nav-aside">
      <div class="side side-dashboard">
        <a class="navbar-brand" href="index.php"><img src="assets/logo.png"></a>
      </div>
      <div class="side side-dashboard">
        <a href="#">Home</a>
      </div>
      <div class="side side-dashboard">
        <a href="#">Dashboard</a>
      </div>
      <div class="side side-dashboard">
        <a href="#">Postar</a>
      </div>
      <div class="side side-dashboard">
        <a href="#">Usuários</a>
      </div>
    </section>
  </div>
  <div class="content-adm">
    <div class="welcome">
      <?php echo "<h3>Seja bem vindo (/* colocar username */) a o <br>Painel de Admin!</h3>"; ?>
    </div>
  </div>
</article>
<script src="javascript/script.js"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
  AOS.init();
</script>
=======

<body>
  <article class="page-main">
    <div class="Seila">
      <section class="nav-aside">
        <div class="side side-dashboard">
          <a class="navbar-brand" href="#"><img src="assets/logo.png"></a>
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

      <div class="tab-content" id="dashboard">
        <div class="welcome">
          <?php
          if (isset($_SESSION['user']['username'])) {
            echo "<h3>Seja bem-vindo " . ($_SESSION['user']['username']) . " ao <br>Painel de Admin!</h3>";
          } else {
            echo 'erro';
            var_dump($_SESSION['user']['username']);
            exit();
          }
          ?>
        </div>
      </div>

      <div class="tab-content" id="postagens" style="display: none;">
        <div class="content">
          <div class="welcome">
            <p>Área de Postagem</p>
          </div>

          <!-- Botão -->
          <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#CriarPostagemModal">
            Criar Nova Postagem
          </button>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="CriarPostagemModal" tabindex="-1" aria-labelledby="CriarPostagemModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="CriarPostagemModalLabel">Nova Receita</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
              </div>
              <div class="modal-body">
                <form id="recipeForm" action="../controller/PostController.php" method="POST" enctype="multipart/form-data">
                  <div class="mb-3">
                    <label for="recipeTitle" class="form-label">Título da Receita</label>
                    <input type="text" class="form-control" id="recipeTitle" name="nome-receita" required>
                  </div>
                  <div class="mb-3">
                    <label for="recipeCategory" class="form-label">Categoria</label>
                    <select class="form-select" id="recipeCategory" name="categoria-receita">
                      <option value="vegetariano">Vegetariano</option>
                      <option value="vegano">Vegano</option>
                      <option value="sem_lactose">Sem Lactose</option>
                      <option value="carnivoro">Carnívoro</option>
                    </select>
                  </div>
                  <div class="mb-3">
                    <label for="recipeIngredients" class="form-label">Ingredientes</label>
                    <textarea class="form-control" id="recipeIngredients" rows="3" name="ingredientes-receita"></textarea>
                  </div>
                  <div class="mb-3">
                    <label for="recipeInstructions" class="form-label">Modo de Preparo</label>
                    <textarea class="form-control" id="recipeInstructions" rows="5" name="modo-receita"></textarea>
                  </div>
                  <div class="mb-3">
                    <label for="recipeTitle" class="form-label">Tempo de Preparo (em minutos)</label>
                    <input type="time" class="form-control" id="recipeTitle recipeTime" name="modo-de-preparo" required>
                  </div>
                  <div class="mb-3">
                    <label for="recipeImage" class="form-label">Imagem da Receita</label>
                    <input type="file" class="form-control" id="recipeImage" name="imagens-receita">
                  </div>
                  <button type="submit" class="btn btn-primary">Postar Receita</button>
                </form>
              </div>
            </div>
          </div>
        </div>

      </div>

      <div class="tab-content" id="usuarios" style="display: none;">
        <div class="welcome">
          <p>Gerenciamento de Usuários</p>
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

    CriarPostagemDialog = () => {
      const postagemSection = document.querySelector('.CriarPostagem');
      if (postagemSection.style.display === 'block') {
        postagemSection.style.display = 'none';
      } else {
        postagemSection.style.display = 'block';
      }
    };
  </script>
>>>>>>> Stashed changes
</body>

</html>