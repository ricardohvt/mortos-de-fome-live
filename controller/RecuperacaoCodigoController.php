<?php
session_start();
require '../model/RecuperacaoCodigoModel.php';

if ($_POST) {
    $codigo = $_POST['codigo'];
    $email = $_SESSION['emailrec']['email'];
    $recuperacao = new RecuperacaoCodigo();

    if ($recuperacao->validarCodigo($codigo, $email)) {
        $_SESSION['codigo_valido'] = true;
        header('Location: ../view/rec.php');
        exit;
    } else {
        $_SESSION['recuperacao_codigo_error'] = "Código inválido ou expirado!";
        header('Location: ../view/rec-codigo.php');
        exit;
    }
}
