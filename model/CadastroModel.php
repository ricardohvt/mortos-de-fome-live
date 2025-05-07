<?php

require '../service/conexao.php';

function register($email, $fullname, $username, $password, $confirmpassword) {
    $conn = new usePDO();
    $instance = $conn->getInstance();

    if ($password !== $confirmpassword) {
        header('Location: ../view/cadastro.php');
        exit;
    }

    $code = mt_rand(100000, 999999); // uso do mt_rand por ser mais seguro que rand
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

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
}
