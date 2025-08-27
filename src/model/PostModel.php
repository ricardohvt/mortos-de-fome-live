<?php
    session_start();
    require '../service/conexao.php';

function cadastrar($nome,$ingredientes,$categoria,$modo,$image){
    $conn = new usePDO();
    $instance = $conn->getInstance();

}

    $sql = "INSERT INTO pessoa (full_name) VALUES (?)";
    $stmt = $instance->prepare($sql);
    $stmt->execute([$fullname]);

    $idPessoa = $instance->lastInsertId();
    $sql = "INSERT INTO user (username, email, password_main, pessoaID) VALUES (?, ?, ?, ?)";
    $stmt = $instance->prepare($sql);
    $stmt->execute([$username, $email, $hashed_password, $idPessoa]);

    $userID = $instance->lastInsertId();

    $sql = "INSERT INTO code (username, code, email, userID) VALUES (?, ?, ?, ?)";
    $stmt = $instance->prepare($sql);
    $stmt->execute([$username, $code, $email, $userID]);

    return $userID;
