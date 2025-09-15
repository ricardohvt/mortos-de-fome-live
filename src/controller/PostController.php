<?php
session_start();
require '../model/PostModel.php';

if ($_POST) {
    $nome = $_POST['nome-receita'];
    $ingredientes = $_POST['ingredientes-receita'];
    $categoria = $_POST['categoria-receita'];
    $modo = $_POST['modo-receita'];
    $image = $_FILES['imagens-receita'];
    $tempoPreparo = (INT) $_POST['tempo-preparo'];
    $userID = $_SESSION['UserID'];

    $result = cadastrarPost($nome, $ingredientes, $categoria, $modo, $image,$tempoPreparo, $userID);


    if (!isset($_SESSION['user']['id'])) {
        $_SESSION['errcode_reg'] = "Usuário não autenticado.";
        header('Location: ../view/login-index.php');
        exit;
    }

    if ($result) {
        $_SESSION['errcode_recipe'] = "Cadastro realizado com sucesso!";
        header('Location: ../view/upload-post-index.php');
        exit;
    } else {
        $_SESSION['errcode_recipe'] = "Não foi possível realizar o cadastro.";
        header('Location: ../view/upload-post-index.php');
        exit;
    }
    
}