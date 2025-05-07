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
        <form action="../controller/RecuperacaoCodigoController.php" method="POST">
            <label for="number">
                <p>Coloque o Código para redefinir a senha:</p>
                <input required type="number" name="codigo" placeholder="Código" maxlength="6"><br>
            </label>
            <button type="submit">Prosseguir</button>
        <?php
            session_start();
            if (!empty($_SESSION['recuperacao_codigo_error'])) {
                echo "<div style='color: red;'>" . $_SESSION['recuperacao_codigo_error'] . "</div>";
                unset($_SESSION['recuperacao_codigo_error']);
            }
        ?>
        </form>
    </section>
    </body>
</html>