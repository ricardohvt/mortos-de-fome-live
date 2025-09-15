<?php
    session_start();
    require '../service/conexao.php';
    date_default_timezone_set('America/Sao_Paulo'); 

function cadastrarPost($nome, $ingredientes, $categoria, $modo, $image, $tempoPreparo, $userID){
    $time = date('Y-m-d H:i:s');
    $conn_post = new usePDO();
    $instance_post = $conn_post->getInstance();
    $sql = "INSERT INTO post (userID, nome_post, ingredientes_post, modoPreparo, tempoPreparo, categoria_postID, criado_em, autorizado) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $instance_post->prepare($sql);
    $stmt->execute([$userID, $nome, $ingredientes, $modo, $time]);
    
    $idPost = $instance_post->lastInsertId();

}

    // $sql = "INSERT INTO pessoa (full_name) VALUES (?)";
    // $stmt = $instance->prepare($sql);
    // $stmt->execute([$fullname]);

    // $idPessoa = $instance->lastInsertId();
    // $sql = "INSERT INTO user (username, email, password_main, pessoaID) VALUES (?, ?, ?, ?)";
    // $stmt = $instance->prepare($sql);
    // $stmt->execute([$username, $email, $hashed_password, $idPessoa]);

    // $userID = $instance->lastInsertId();

    // $sql = "INSERT INTO code (username, code, email, userID) VALUES (?, ?, ?, ?)";
    // $stmt = $instance->prepare($sql);
    // $stmt->execute([$username, $code, $email, $userID]);

    // return $userID;
