<?php

// Jean, tem algo escondido pra vc no dashboard!

session_start();
require '../model/AuthModel.php';

if ($_POST) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $usuario = new Usuario();
    $result = $usuario->login($email, $password);

    if ($result) {
        $_SESSION['login_error'] = null; 
        header("Location: ../view/index.php");
        exit;
    } else {
        $_SESSION['login_error'] = "Email ou senha estão errados!";
        header("Location: ../view/login.php");
        exit;
    }
}

?>