<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="Author" content="Ricardo Henrique Vieira Tomba">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="style/style-main.css">
</head>
<body>
    <section class="env">
        <form action="../controller/AuthController.php" method="POST">
            <div class="text">
                <h1>Login</h1>
            </div>
            <hr>
            <label for="email">
                <p>Seu E-mail:</p>
                <input required type="email" name="email" id="input-email" class="input-email" placeholder="E-mail"><br>
            </label>
            <label for="password">
                <p>Sua senha:</p>
                <input required type="password" name="password" id="input-password" class="input-password" placeholder="Senha"><br>
            </label>
            <hr>
            <div class="login-check">
            <?php
                session_start();

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
            <div class="links">
                <a href="rec-usuario.php">Esqueci minha senha</a><br>
                <a href="cadastro.php">Ainda não possui cadastro?</a><br>
            </div>
            <button type="submit">Login</button>
        </form>
    </section>
</body>
</html>