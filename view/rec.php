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
        <form action="../controller/RedefinirSenhaController.php" method="POST">
            <label for="password">
                <p>Digite a nova senha:</p>
                <input required type="password" name="password" placeholder="Nova senha"><br>
            </label>
            <label for="password-confirm">
                <p>Confirme a nova senha:</p>
                <input required type="password" name="password-confirm" placeholder="Confirmar senha"><br>
            </label>
            <button type="submit">Redefinir senha</button>
        <?php
        session_start();
        if (!empty($_SESSION['redefinir_senha_error'])) {
            echo "<div style='color: red;'>" . $_SESSION['redefinir_senha_error'] . "</div>";
            unset($_SESSION['redefinir_senha_error']);
        }
        ?>
        </form>
    </section>
</body>
</html>