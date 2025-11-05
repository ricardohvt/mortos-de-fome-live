<?php
session_start();
require '../model/PostModel.php';

if ($_POST) {
    // Verificar se usuário está logado
    if (!isset($_SESSION['user']['userID'])) {
        $_SESSION['errcode_reg'] = "Usuário não autenticado.";
        header('Location: ../view/login-index.php');
        exit;
    }

    // Coletar dados do formulário
    $nome = $_POST['nome-receita'] ?? '';
    $ingredientes = $_POST['ingredientes-receita'] ?? '';
    $categoria = $_POST['categoria-receita'] ?? '';
    $modo = $_POST['modo-receita'] ?? '';
    $image = $_FILES['imagens-receita'] ?? [];
    $tempoPreparo = (int) ($_POST['tempo-preparo'] ?? 0);
    $userID = $_SESSION['user']['userID'];

    // Validar dados obrigatórios
    if (empty($nome) || empty($ingredientes) || empty($categoria) || empty($modo)) {
        $_SESSION['errcode_recipe'] = "Preencha todos os campos obrigatórios.";
        header('Location: ../view/upload-post-index.php');
        exit;
    }

    $result = cadastrarPost($nome, $ingredientes, $categoria, $modo, $image, $tempoPreparo, $userID);

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
?>