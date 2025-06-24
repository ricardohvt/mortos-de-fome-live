<?php
session_start();
?>


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
      <div class="side side-dashboard btn-down-logout">
        <a href="../model/LogoutModel.php" style="text-decoration: none; color: inherit;">Logout</a>
      </div>

    </section>
  </div>
  <div class="content-adm">
    <div class="welcome">
      <?php
      if (isset($_SESSION['user']['username'])) {
        echo "<h3>Seja bem vindo " . ($_SESSION['user']['username']) . " a o <br>Painel de Admin!</h3>";
      } else {
        echo 'erro';
        var_dump($_SESSION['user']['username']);
        exit();
      }
      ?>
    </div>
  </div>
</article>
<script src="javascript/script.js"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
  AOS.init();
</script>
</body>

</html>