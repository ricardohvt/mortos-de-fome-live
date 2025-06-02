<?php
session_start();
require '../model/RedefinirSenhaModel.php';

if ($_POST) {
    $novaSenha = $_POST['password'];
    $confirmarSenha = $_POST['password-confirm'];

    if ($novaSenha !== $confirmarSenha) {
        $_SESSION['redefinir_senha_error'] = "As senhas não coincidem!";
        header('Location: ../view/rec.php');
        exit;
    }

    $redefinir = new RedefinirSenha();
    if ($redefinir->atualizarSenha($_SESSION['emailrec']['userID'], $novaSenha)) {
        $_SESSION['redefinir_senha_success'] = "Senha redefinida com sucesso!";
        header('Location: ../view/login-index.php');
        exit;
    } else {
        $_SESSION['redefinir_senha_error'] = "Erro ao redefinir a senha!";
        header('Location: ../view/rec.php');
        exit;
    }
}

