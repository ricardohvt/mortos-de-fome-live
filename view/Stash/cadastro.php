<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="Author" content="Ricardo Henrique Vieira Tomba">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro</title>
    <link rel="stylesheet" href="style/style-main.css">
</head>

<body>
    <section class="env">
        <form action="../controller/CadastroController.php" method="POST">
            <div class="text">
                <h1>Cadastro</h1>
            </div>
            <hr>
            <label for="">
                <p>Seu E-mail para cadastro:</p>
                <input required type="email" name="email" id="input-email" class="input-email" placeholder="E-mail"><br>
            </label>
            <label for="">
                <p>Seu nome de Usuário:</p>
                <input required type="text" name="username" id="input-user" placeholder="Nome de usuário"><br>
            </label>
            <label for="">
                <p>Seu nome completo:</p>
                <input required type="text" name="fullname" id="input-name" placeholder="Nome completo"><br>
            </label>
            <label for="password">
                <p>Sua senha:</p>
                <input required type="password" name="password" id="input-password" class="input-password" placeholder="Senha"><br>
            </label>
            <label for="password-conf">
                <p>Confirmar sua senha:</p>
                <input required type="password" name="confirm_password" id="input-password-confirm" class="input-password" placeholder="Confirmar senha"><br>
            </label>
            <hr>
            <?php
                session_start();

                if (!empty($_SESSION['errcode_reg'])) {
                    echo $_SESSION['errcode_reg'];
                    unset($_SESSION['errcode_reg']);
                }
            ?>
            <div class="button-main">
                <button class="button-submit">Cadastrar</button>
            </div>
        </form>
    </section>
</body>

</html>