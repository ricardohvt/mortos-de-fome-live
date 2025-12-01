<?php
session_start()
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

<body><section class="main-modal" data-aos="fade-up">
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

    <form action="../controller/RecuperacaoCodigoController.php" method="POST" class="main-form">
      <div class="content">
        <div class="text">
          <h1>Coloque o Código para redefinir a senha:</h1>
        </div>
        <hr>

        <label for="codigo">
          <input required type="number" name="codigo" placeholder="Código" maxlength="6" class="input-email input"><br>
        </label>

        <hr>

        <?php
        if (!empty($_SESSION['recuperacao_codigo_error'])) {
          echo "<div style='color: red;'>" . $_SESSION['recuperacao_codigo_error'] . "</div>";
          unset($_SESSION['recuperacao_codigo_error']);
        }
        ?>

        <div class="button-main">
          <button type="submit" class="button-submit btn-r">Prosseguir</button>
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