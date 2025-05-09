<?php
session_start();
require '../model/CadastroModel.php';
if($_POST){
    $email = $_POST['email'];
    $username = $_POST['username'];
    $fullname = $_POST['fullname'];
    $password = $_POST['password'];
    $confirmpassword = $_POST['confirm_password'];
    
    if($password !== $confirmpassword){
        $_SESSION['errcode_reg'] = "As senhas não combinam!";
        header('Location: ../view/cadastro.php');
        exit;
    }else {
        
        $result = register($email, $fullname, $username, $password, $confirmpassword);
        
        if($result){
            $_SESSION['errcode_reg'] = "Cadastro realizado!";
            header('Location: ../view/login.php');
            exit;
        }else {
            $_SESSION['errcode_reg'] = "Não foi possível realizar o cadastro";
            header('Location: ../view/cadastro.php');
            exit;
        }
    }
} 
