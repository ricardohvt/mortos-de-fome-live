<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Mortos de fome - Postar Receita</title>
  <link rel="stylesheet" href="style/post-style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
    integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>
  <link rel="icon" href="assets/marsal.png" type="image/png">
</head>

<body>
  <nav class="navbar navbar-expand-lg">
    <div class="container-fluid">
      <a class="navbar-brand" href="index.php"><img src="assets/logo.png" alt="Logo"> </a>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="#"><i class="fa-solid fa-house"></i></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Em alta</a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Menu
            </a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="#">Receitas</a></li>
            </ul>
          </li>
          <li class="nav-item-1">
            <a class="login" onclick="inpLogin()"><img class="usr-img" src="assets/user.svg" alt="Usuário" height="25px"
                width="25px"></a>
          </li>
        </ul>
      </div>
      <div class="icons-main-centered">
        <div class="plant-container">
          <a href="vegetariano-index.php"><img src="assets/image 3.png" height="30px"></a>
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
          <a href="fitness-index.php"><img src="assets/fit.svg" height="30px" width="30px"></a>
        </div>
      </div>
    </div>
  </nav>

  <!-- Formulário para postar receita -->
  <section class="post-recipe">
    <div class="container">
      <h2 class="section-title">Poste sua Receita</h2>
      <form id="recipeForm">
        <div class="mb-3">
          <label for="recipeTitle" class="form-label">
            <span class="title">
              Título da Receita
            </span>
          </label>
          <input type="text" class="form-control" id="recipeTitle" placeholder="Digite o título da receita">
        </div>
        <div class="mb-3">
          <label for="recipeCategory" class="form-label">
            <span class="categoria">
              Categoria
            </span>
          </label>
          <select class="form-select" id="recipeCategory">
            <option value="vegetariano">Vegetariano</option>
            <option value="vegano">Vegano</option>
            <option value="sem_lactose">0 Lactose</option>
            <option value="sem_glúten">0 glúten</option>
            <option value="sem_glúten">0 açucar</option>
          </select>
        </div>
        <div class="mb-3">
          <label for="recipeIngredients" class="form-label">
            <span class="ingredientes">
              Ingredientes
            </span>
          </label>
          <textarea class="form-control" id="recipeIngredients" rows="3"
            placeholder="Digite os ingredientes da receita"></textarea>
        </div>
        <div class="mb-3">
          <label for="recipeInstructions" class="form-label">
            <span class="modo">
              Modo de Preparo
            </span>
          </label>
          <textarea class="form-control" id="recipeInstructions" rows="5"
            placeholder="Digite o modo de preparo da receita"></textarea>
        </div>
        <div class="mb-3">
          <label for="recipeImage" class="form-label">
            <span class="rec-img">
              Imagem da Receita
            </span>
          </label>
          <input type="file" class="form-control" id="recipeImage">
        </div>
        <button type="submit" class="btn btn-primary">Postar Receita</button>
      </form>
    </div>
  </section>

  <footer class="footer">
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
      </div>
      <hr class="footer-divider">
      <div class="footer-bottom"></div>
    </div>
  </footer>
  <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
  <script src="javascript/script.js"></script>
</body>

</html>