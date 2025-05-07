<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="Author" content="Ricardo Henrique Vieira Tomba">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperação</title>
    <link rel="stylesheet" href="style/style-main.css">
</head>
<body>
    <section class="env">
        <form action="../controller/RecuperacaoEmailController.php" method="POST">
            <div class="text">
                <h1>Recuperação de senha</h1>
            </div>
            <hr>
            <label for="email">
                <p>Email:</p>
                <input required type="email" name="email" id="input-username" class="input-username" placeholder="Nome de usuário"><br>
            </label>
            <hr>
        <?php
                session_start();

                if (!empty($_SESSION['recuperacaoem_error'])) {
                    echo $_SESSION['recuperacaoem_error'];
                    unset($_SESSION['recuperacaoem_error']);
                }
            ?>
            <div class="button-main">
                <button class="button-submit">Prosseguir</button>
            </div>
        </form>
    </section>
</body>
</html>