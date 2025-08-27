<?php
session_start();
require '../model/PostModel.php';

if ($_POST) {
    $nome = $_POST['nome-receita'];
    $ingredientes = $_POST['ingredientes-receita'];
    $categoria = $_POST['categoria-receita'];
    $modo = $_POST['modo-receita'];
    $image = $_FILES['imagens-receita'];

    $result = cadastrar($nome,$ingredientes,$categoria,$modo,$image);

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