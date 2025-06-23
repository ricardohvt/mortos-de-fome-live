<?php
session_start();
?>
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
<section class="main-modal">
  <section class="modal-content">

    <div class="form-box">
      <div class="container-fluid position-relative">
        <a class="navbar-brand" href="index.php">
          <img src="assets/logo.svg" alt="Logo">
        </a>
      </div>
      <div class="container-fluid position-relative container-2">
      </div>
    </div>

    <form action="../controller/RedefinirSenhaController.php" method="POST" class="main-form">
      <div class="content">
        <div class="text">
          <h1>Recuperação</h1>
        </div>
        <hr>

        <label for="password">
          <p>Digite a nova senha:</p>
          <input required type="password" name="password" class="input" placeholder="Nova senha"><br>
        </label>

        <label for="password-confirm">
          <p>Confirme a nova senha:</p>
          <input required type="password" name="password-confirm" class="input" placeholder="Confirmar senha"><br>
        </label>

        <hr>

        <?php
        if (!empty($_SESSION['redefinir_senha_error'])) {
          echo "<div style='color: red;'>" . $_SESSION['redefinir_senha_error'] . "</div>";
          unset($_SESSION['redefinir_senha_error']);
        }
        ?>

        <div class="button-main">
          <button class="button-submit btn-r" type="submit">Redefinir senha</button>
        </div>
      </div>
    </form>

  </section>
</section>

    <script src="javascript/script.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
      AOS.init();
    </script>
</body>

</html>