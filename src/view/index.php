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
    <nav class="navbar navbar-expand-lg position-relative">
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
                                    <?php
            session_start();
            if (isset($_SESSION['user'])) {
                echo '<img class="usr-img" src="assets/user.svg" alt="Usuário" height="25px" width="25px">' ."Você está logado, " . ($_SESSION['user']['username']) . "!";
            } else {
                echo "Login";
            }
        ?>
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
    <div class="search">
        <form class="d-flex" role="search">
            <input class="form-control me-2" type="search" placeholder="Busque uma receita ou ingredientes"
                aria-label="Search">
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
  <section>
    <div class="cards-main">
      <h1 class="rec-title" data-aos="fade-up">Receitas</h1>
      <div class="cards">
        <div class="cartao" data-aos="fade-up">
          <a href="post-bowl-index.php">
            <img src="assets/bowl.jpg" alt="Receita Vegana" class="cartao-img">
            <div class="cartao-content">
              <h3 class="cartao-title">Bowl Vegano Nutritivo</h3>
              <p class="cartao-text">Um delicioso bowl repleto de vegetais frescos,boa salada em qualquer ocasião</p>
              <div class="cartao-footer">
                <span><i class="fa-regular fa-clock"></i> 25 min</span>
                <span><i class="fa-regular fa-heart"></i> 234</span>
              </div>
            </div>
          </a>
        </div>

        <div class="cartao" data-aos="fade-up">
          <a href="">
            <img src="assets/alpomodoro.jpg" alt="Massa Italiana" class="cartao-img">
            <div class="cartao-content">
              <h3 class="cartao-title">Pasta al Pomodoro sem gluten</h3>
              <p class="cartao-text">Massa italiana autêntica com molho de tomate caseiro e manjericão fresco sem gluten.</p>
              <div class="cartao-footer">
                <span><i class="fa-regular fa-clock"></i> 30 min</span>
                <span><i class="fa-regular fa-heart"></i> 189</span>
              </div>
            </div>
          </a>
        </div>

        <div class="cartao" data-aos="fade-up">
          <a href="">
            <img src="assets/salmao.png" alt="Prato Saudável" class="cartao-img">
            <div class="cartao-content">
              <h3 class="cartao-title">Salmão Grelhado</h3>
              <p class="cartao-text">Salmão grelhado com legumes assados e molho de ervas.</p>
              <div class="cartao-footer">
                <span><i class="fa-regular fa-clock"></i> 35 min</span>
                <span><i class="fa-regular fa-heart"></i> 276</span>
              </div>
            </div>
          </a>
        </div>

        <div class="cartao" data-aos="fade-up">
          <a href="">
            <img src="assets/cheesecake.jpg" alt="Sobremesa" class="cartao-img">
            <div class="cartao-content">
              <h3 class="cartao-title">Cheesecake de Frutas</h3>
              <p class="cartao-text">Cheesecake cremoso com cobertura de frutas vermelhas frescas.</p>
              <div class="cartao-footer">
                <span><i class="fa-regular fa-clock"></i> 45 min</span>
                <span><i class="fa-regular fa-heart"></i> 312</span>
              </div>
            </div>
          </a>
        </div>


        <div class="cartao" data-aos="fade-up">
          <a href="">
            <img src="assets/panceca.jpg" alt="Café da Manhã" class="cartao-img">
            <div class="cartao-content">
              <h3 class="cartao-title">Panqueca de morango sem leite</h3>
              <p class="cartao-text">Panquecas de morango com frutas frescas e mel orgânico.</p>
              <div class="cartao-footer">
                <span><i class="fa-regular fa-clock"></i> 20 min</span>
                <span><i class="fa-regular fa-heart"></i> 198</span>
              </div>
            </div>
          </a>
        </div>

        <div class="cartao" data-aos="fade-up">
          <a href="">
            <img src="assets/brownie2.jpg" alt="Sobremesa Especial" class="cartao-img">
            <div class="cartao-content">
              <h3 class="cartao-title">Brownie de morango sem açucar</h3>
              <p class="cartao-text">Brownie de morango delicioso feito com leite e morango sem açucar</p>
              <div class="cartao-footer">
                <span><i class="fa-regular fa-clock"></i> 40 min</span>
                <span><i class="fa-regular fa-heart"></i> 245</span>
              </div>
            </div>
          </a>
        </div>
      </div>
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