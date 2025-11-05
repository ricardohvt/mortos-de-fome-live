<?php
session_start();
include_once '../service/conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verificar se usuário está logado
    if (!isset($_SESSION['user']['userID'])) {
        $_SESSION['error'] = "Usuário não autenticado.";
        header("Location: ../painel.php");
        exit();
    }
    
    // Coletar dados
    $userID = $_SESSION['user']['userID'];
    $nome_post = trim($_POST['nome-receita'] ?? '');
    $subtitulo_post = trim($_POST['subtitulo-receita'] ?? '');
    $ingredients = trim($_POST['ingredientes-receita'] ?? '');
    $modoPreparo = trim($_POST['modo-receita'] ?? '');
    $categoria_postID = intval($_POST['categoria-receita'] ?? 0);
    
    $conexao = instance2();
    
    // DEBUG
    error_log("Tentando inserir post com categoria ID: " . $categoria_postID);
    
    // Validar dados
    if (empty($nome_post) || empty($ingredients) || empty($modoPreparo) || $categoria_postID <= 0) {
        $_SESSION['error'] = "Preencha todos os campos obrigatórios.";
        header("Location: ../painel.php");
        exit();
    }
    
    // Inserir post - método mais simples e direto
    $sql = "INSERT INTO post (userID, nome_post, subtitulo_post, ingredients, modoPreparo, categoria_postID, autorizado) 
            VALUES (?, ?, ?, ?, ?, ?, 1)";
    
    $stmt = $conexao->prepare($sql);
    if ($stmt === false) {
        $_SESSION['error'] = "Erro no prepare: " . $conexao->error;
        header("Location: ../painel.php");
        exit();
    }
    
    $stmt->bind_param("issssi", $userID, $nome_post, $subtitulo_post, $ingredients, $modoPreparo, $categoria_postID);
    
    if ($stmt->execute()) {
        $postID = $conexao->insert_id;
        $_SESSION['success'] = "Post criado com sucesso!";
        
        // Processar imagens se existirem
        if (!empty($_FILES['imagens-receita']['name'][0])) {
            foreach ($_FILES['imagens-receita']['tmp_name'] as $key => $tmp_name) {
                if ($_FILES['imagens-receita']['error'][$key] === UPLOAD_ERR_OK) {
                    $imageData = file_get_contents($tmp_name);
                    $sql_img = "INSERT INTO post_images (PostID, image) VALUES (?, ?)";
                    $stmt_img = $conexao->prepare($sql_img);
                    $stmt_img->bind_param("ib", $postID, $imageData);
                    $stmt_img->send_long_data(1, $imageData);
                    $stmt_img->execute();
                    $stmt_img->close();
                }
            }
        }
    } else {
        $_SESSION['error'] = "Erro ao criar post: " . $stmt->error;
    }
    
    $stmt->close();
    $conexao->close();
    
    header("Location: ../view/painel.php");
    exit();
}
?>