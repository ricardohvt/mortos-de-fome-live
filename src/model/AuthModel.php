<?php

require '../service/conexao.php';

class Usuario {
    public function login($email, $password){
        $conn = new usePDO();
        $instance = $conn->getInstance();    
        try {
            $sql = "SELECT * FROM user WHERE email = :email";
            $stmt = $instance->prepare($sql);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->execute();

            if ($stmt->rowCount() > 0){
                $user = $stmt->fetch(PDO::FETCH_ASSOC);
                if (password_verify($password, $user['password_main'])) {
                    session_start(); 
                    $_SESSION['user'] = $user; 
                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        } catch(PDOException $e){
            die("Erro: ". $e->getMessage());
        }
    }
}
