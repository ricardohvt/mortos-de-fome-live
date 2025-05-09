<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Landing Page</title>
    <link rel="stylesheet" href="style/style-main.css">
</head>
<body>
    <section>
        <a href="dashboard.php" class="button">Dashboard</a>
        <a href="login.php" class="button">Login</a>
        <a href="cadastro.php" class="button">Cadastro</a>
        <a href="rec-usuario.php" class="button">Recuperação</a>
        <a href="assets/auth.pdf" class="button">Fluxo</a>
    </section>

    <div class="check">
        <?php
            session_start();
            if (isset($_SESSION['user'])) {
                echo "Você está logado, " . ($_SESSION['user']['username']) . "!";
            } else {
                echo "Você não está logado!";
            }
        ?>
    </div>
</body>
</html>
