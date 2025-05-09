<?php
session_start();
require '../model/RecuperacaoEmailModel.php';

if ($_POST) {
    $email = $_POST['email'];
    $recuperacao = new emailRec();

    if ($recuperacao->EmailRec($email)) {
        $_SESSION['recuperacao_email_success'] = "Código enviado para o email!";
        header('Location: ../view/rec-codigo.php');
        exit;
    } else {
        $_SESSION['recuperacaoem_error'] = "Email não encontrado!";
        header('Location: ../view/rec-usuario.php');
        exit;
    }
}
