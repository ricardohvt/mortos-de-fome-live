<?php
session_start();
require '../model/CadastroModel.php';

if ($_POST) {
    $email = $_POST['email'];
    $username = $_POST['username'];
    $fullname = $_POST['fullname'];
    $password = $_POST['password'];
    $confirmpassword = $_POST['confirm_password'];

    $email_check = check($email);


    if($email_check){
        $_SESSION['errcode_reg'] = "Já há um usuário cadastrado com esse E-mail";
        header('Location: ../view/cadastro-index.php');
        return;
    }

    if ($password !== $confirmpassword) {
        $_SESSION['errcode_reg'] = "As senhas não combinam!";
        header('Location: ../view/cadastro-index.php');
        exit;
    }

    $result = register($email, $fullname, $username, $password, $confirmpassword,);

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
