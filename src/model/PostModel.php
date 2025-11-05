<?php
require '../service/conexao.php';
date_default_timezone_set('America/Sao_Paulo'); 

function cadastrarPost($nome, $ingredientes, $categoria, $modo, $image, $tempoPreparo, $userID) {
    $time = date('Y-m-d H:i:s');
    $conexao = instance2();
    
    try {
        // Iniciar transação
        $conexao->begin_transaction();
        
        // Inserir post - CORRIGIDO: usando os nomes corretos das colunas
        $sql = "INSERT INTO post (userID, nome_post, subtitulo_post, ingredients, modoPreparo, categoria_postID, criado_em, autorizado) 
                VALUES (?, ?, '', ?, ?, ?, ?, 0)";
        $stmt = $conexao->prepare($sql);
        $stmt->bind_param("issisis", $userID, $nome, $ingredientes, $modo, $categoria, $time);
        
        if (!$stmt->execute()) {
            throw new Exception("Erro ao inserir post: " . $stmt->error);
        }
        
        $idPost = $conexao->insert_id;
        
        // Processar imagens se existirem
        if (!empty($image) && isset($image['tmp_name']) && is_array($image['tmp_name'])) {
            foreach ($image['tmp_name'] as $key => $tmp_name) {
                if ($image['error'][$key] === 0 && is_uploaded_file($tmp_name)) {
                    $check = getimagesize($tmp_name);
                    if ($check !== false) {
                        $imageData = file_get_contents($tmp_name);
                        $sql_img = "INSERT INTO post_images (PostID, image) VALUES (?, ?)";
                        $stmt_img = $conexao->prepare($sql_img);
                        $stmt_img->bind_param("ib", $idPost, $imageData);
                        $stmt_img->send_long_data(1, $imageData);
                        
                        if (!$stmt_img->execute()) {
                            throw new Exception("Erro ao inserir imagem: " . $stmt_img->error);
                        }
                        $stmt_img->close();
                    }
                }
            }
        }
        
        // Commit da transação
        $conexao->commit();
        $stmt->close();
        return $idPost;
        
    } catch (Exception $e) {
        // Rollback em caso de erro
        $conexao->rollback();
        error_log("Erro ao cadastrar post: " . $e->getMessage());
        return false;
    } finally {
        $conexao->close();
    }
}
?>