<?php
session_start();
require '../model/CadastroModel.php';

if ($_POST) {
    $email = trim($_POST['email']);
    $username = trim($_POST['username']);
    $fullname = trim($_POST['fullname']);
    $password = $_POST['password'];
    $confirmpassword = $_POST['confirm_password'];
    $isAdminVar = isset($_POST['isAdmin']) ? 1 : null;

    if ($password !== $confirmpassword) {
        $_SESSION['errcode_reg'] = "As senhas não combinam!";
        header('Location: ../view/cadastro-index.php');
        exit;
    }

    $result = register($email, $fullname, $username, $password, $confirmpassword, $isAdminVar);

    if ($result) {
        $_SESSION['errcode_reg'] = "Cadastro realizado com sucesso!";
        header('Location: ../view/login-index.php');
        exit;
    } else {
        $_SESSION['errcode_reg'] = "Não foi possível realizar o cadastro.";
        header('Location: ../view/cadastro-index.php');
        exit;
    }
}
