<!DOCTYPE php>
<php lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Mortos de Fome - Login</title>
  <link rel="stylesheet" href="style/login-style.css">
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
</head>

<body>
  <nav class="navbar navbar-expand-lg ">
    <div class="container-fluid">
      <a class="navbar-brand" href="index.php"><img src="assets/logo.png"></a>

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
              <li><a class="dropdown-item" href="#"></a></li>
              <li><a class="dropdown-item" onclick="mostrarconversor()">Conversor de medidas</a></li>
              <li>
                <hr class="dropdown-divider">
              </li>
              <li><a class="dropdown-item" href="upload-post-index.php">Postar</a></li>
            </ul>
          </li>
          <li class="nav-item-1">
            <a class="login" onclick="inpLogin()"><img class="usr-img" src="assets/user.svg" alt="Usuário" height="25px"
                width="25px"></a>
          </li>
        </ul>

      </div>
    </div>
  </nav>
  <aside id="conversor">
    <div class="conversor">
      <label for="quantity">Quantidade:</label><br>
      <input type="number" name="quantity" id="quantity" placeholder="Quantidade" class="input"><br>

      <label for="unit_from">De:</label>
      <select name="unit_from" id="unit_from" class="input">
        <!-- Unidades de Peso -->
        <option value="g">Gramas (g)</option>
        <option value="kg">Quilogramas (kg)</option>
        <option value="lb">Libras (lb)</option>
        <option value="oz">Onças (oz)</option>
        <!-- Unidades de Volume -->
        <option value="ml">Mililitros (ml)</option>
        <option value="l">Litros (l)</option>
        <option value="colher_de_cha">Colheres de chá (colher_de_cha)</option>
        <option value="colher_de_sopa">Colheres de sopa (colher_de_sopa)</option>
        <option value="xicara">Xícaras (xicara)</option>
      </select><br>
      <label for="unit_to">Para:</label>
      <select name="unit_to" id="unit_to" class="input">
        <!-- Unidades de Peso -->
        <option value="g">Gramas (g)</option>
        <option value="kg">Quilogramas (kg)</option>
        <option value="lb">Libras (lb)</option>
        <option value="oz">Onças (oz)</option>
        <!-- Unidades de Volume -->
        <option value="ml">Mililitros (ml)</option>
        <option value="l">Litros (l)</option>
        <option value="colher_de_cha">Colheres de chá (colher_de_cha)</option>
        <option value="colher_de_sopa">Colheres de sopa (colher_de_sopa)</option>
        <option value="xicara">Xícaras (xicara)</option>
      </select>

      <button onclick="convertUnits()" class="btn-1">Converter</button>
      <button onclick="fecharconversor()" class="btn-1">Fechar</button>
      <div id="result"></div>
    </div>
  </aside>
  <section class="main-modal">
    <form action="../controller/AuthController.php" method="POST" class="main-form">
      <div class="text">
        <h1>Login</h1>
      </div>
      <label for="">
        <p>Seu E-mail:</p>
        <input required type="email" name="email" id="input-email" class="input-email input" placeholder="E-mail"><br>
      </label>
      <label for="password">
        <p>Sua senha:</p>
        <input required type="password" name="password" id="input-password" class="input-password input" placeholder="Senha"><br>
      </label>
      <div class="form-link">
        <a href="cadastro-index.php">Cadastrar-se</a>
      </div>
      <div class="login-check">
        <?php
        // session_start();

        if (!empty($_SESSION['login_error'])) {
          echo "<div style='color: red;'>" . $_SESSION['login_error'] . "</div>";
          unset($_SESSION['login_error']);
        }
        if (!empty($_SESSION['errcode_reg'])) {
          echo $_SESSION['errcode_reg'];
          unset($_SESSION['errcode_reg']);
        }
        ?>
      </div>
      <div class="button-main">
        <button class="button-submit btn-r">Login</button>
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
              <a href="" class="tag-a-main">2024 Mortos de fome. Todos os direitos reservados</a>
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

</php>