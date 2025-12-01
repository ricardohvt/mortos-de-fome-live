<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Mortos de Fome - Cadastro</title>
  <link rel="stylesheet" href="https:
    integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link href="https:
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <script src="https:
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>
  <link rel="preconnect" href="https:
  <link rel="preconnect" href="https:
  <link
    href="https:
    rel="stylesheet">
  <link rel="preconnect" href="https:
  <link rel="preconnect" href="https:
  <link
    href="https:
    rel="stylesheet">
  <link href="https:
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
    <script src="https:
    <script>
      AOS.init();
    </script>
</body>

</html>