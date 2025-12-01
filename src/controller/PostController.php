<?php

session_start();
include_once '../service/conexao.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: ../view/index.php");
    exit();
}


if (!isset($_SESSION['user']['userID'])) {
    $_SESSION['error'] = "Usuário não autenticado.";
    header("Location: ../view/login-index.php");
    exit();
}

$conexao = instance2();


$userID     = intval($_SESSION['user']['userID']);
$nome       = trim($_POST['nome-receita'] ?? '');
$descricao  = trim($_POST['descricao-receita'] ?? '');
$ingredients= trim($_POST['ingredientes-receita'] ?? '');
$modo       = trim($_POST['modo-receita'] ?? '');
$categoria  = intval($_POST['categoria-receita'] ?? 0);


if ($userID <= 0 || $nome === '' || $ingredients === '' || $modo === '' || $categoria <= 0) {
    $_SESSION['error'] = "Preencha todos os campos obrigatórios.";
    header("Location: ../view/painel-usuario.php");
    exit();
}


$sql = "INSERT INTO post (userID, nome_post, descricao_post, ingredients, modoPreparo, categoria_postID, autorizado)
        VALUES (?, ?, ?, ?, ?, ?, 0)";
$stmt = $conexao->prepare($sql);
if ($stmt === false) {
    $_SESSION['error'] = "Erro no prepare: " . $conexao->error;
    header("Location: ../view/painel-usuario.php");
    exit();
}


if (!$stmt->bind_param("issssi", $userID, $nome, $descricao, $ingredients, $modo, $categoria)) {
    $_SESSION['error'] = "Erro no bind_param: " . $stmt->error;
    $stmt->close();
    $conexao->close();
    header("Location: ../view/painel-usuario.php");
    exit();
}

if (!$stmt->execute()) {
    $_SESSION['error'] = "Erro ao criar post: " . $stmt->error;
    $stmt->close();
    $conexao->close();
    header("Location: ../view/painel-usuario.php");
    exit();
}

$postID = $conexao->insert_id;
$stmt->close();


if (!empty($_FILES['imagens-receita']['name'][0])) {
    foreach ($_FILES['imagens-receita']['tmp_name'] as $key => $tmp_name) {
        if (isset($_FILES['imagens-receita']['error'][$key]) && $_FILES['imagens-receita']['error'][$key] === UPLOAD_ERR_OK) {
            $imageData = file_get_contents($tmp_name);
            $sql_img = "INSERT INTO post_images (PostID, image) VALUES (?, ?)";
            $stmt_img = $conexao->prepare($sql_img);
            if ($stmt_img) {
                
                $null = null;
                $stmt_img->bind_param("ib", $postID, $null);
                
                $stmt_img->send_long_data(1, $imageData);
                $stmt_img->execute();
                $stmt_img->close();
            }
        }
    }
}


$isAdmin = intval($_SESSION['user']['isAdmin'] ?? 0);
$redirect = $isAdmin === 1 ? '../view/painel.php' : '../view/painel-usuario.php';
$_SESSION['success'] = "Post criado com sucesso!";
$conexao->close();
header("Location: $redirect");
exit();
?>
