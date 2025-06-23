<?php
session_start();
require '../model/AuthModel.php';

if ($_POST) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $usuario = new Usuario();
    $result = $usuario->login($email, $password);

    if ($result) {
        $_SESSION['login_error'] = null;
        if (isset($_SESSION['user']['isAdmin']) && $_SESSION['user']['isAdmin'] == 1) {
            header("Location: ../view/painel.php"); 
            exit;
        } else {
            header("Location: ../view/painel-usuario.php"); 
            exit;
        }
    } else {
        $_SESSION['login_error'] = "Email ou senha estão errados!";
        header("Location: ../view/login-index.php");
        exit;
    }
}
