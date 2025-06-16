<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Mortos de Fome - Cadastro</title>
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
  <link rel="stylesheet" href="style/login-style.css">
  <link rel="icon" href="assets/marsal.png" type="image/png">
</head>

<body>
  <nav class="navbar navbar-expand-lg position-relative">
    <div class="container-fluid position-relative">
      <a class="navbar-brand" href="index.php">
        <img src="assets/logo.png"
          alt="Logo"> </a>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="http://localhost/mortos-de-fome-joao/mortos-de-fome-live-develop-pedro%20(1)/mortos-de-fome-live-develop-pedro/src/view/index.php"><i class="fa-solid fa-house"></i></a>
          </li>
          <li class="nav-item">
            </a>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
              <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                  <a id="navpal" class="nav-link" href="#">Em alta</a>
                </li>
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
                  <a class="login" onclick="inpLogin()">
                    <img class="usr-img" src="assets/user.svg" alt="Usuário" height="25px" width="25px">
                  </a>
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
<section class="main-modal" data-aos="fade-up">
  <form action="../controller/CadastroController.php" method="POST" class="main-form">
    <div class="text">
      <h1>Cadastro</h1>
    </div>
    <div class="content">

      <label for="input-email">
        <p>Seu E-mail para cadastro:</p>
        <input required type="email" name="email" id="input-email" class="input" placeholder="E-mail">
      </label>

      <label for="input-user">
        <p>Seu nome de Usuário:</p>
        <input required type="text" name="username" id="input-user" class="input" placeholder="Nome de usuário">
      </label>

      <label for="input-name">
        <p>Seu nome completo:</p>
        <input required type="text" name="fullname" id="input-name" class="input" placeholder="Nome completo">
      </label>

      <label for="input-password">
        <p>Sua senha:</p>
        <input required type="password" name="password" id="input-password" class="input" placeholder="Senha">
      </label>

      <label for="input-password-confirm">
        <p>Confirmar sua senha:</p>
        <input required type="password" name="confirm_password" id="input-password-confirm" class="input" placeholder="Confirmar senha">
      </label>

      <div class="form-check">
        <input class="form-check-input" type="checkbox" role="switch" id="switchCheckChecked" name="isAdmin" value="1">
        <label class="form-check-label" for="switchCheckChecked">Admin</label>
      </div>

      <div class="form-link">
        <a href="login-index.php">Logar</a>
      </div>

      <?php
      if (!empty($_SESSION['errcode_reg'])) {
        echo "<p class='error-msg'>" . $_SESSION['errcode_reg'] . "</p>";
        unset($_SESSION['errcode_reg']);
      }
      ?>

      <div class="button-main">
        <button type="submit" class="button-submit btn-r">Cadastrar</button>
      </div>

    </div>
  </form>
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