<?php

require '../service/conexao.php';

class Usuario {
    public function login($email){
        $conn = new usePDO();
        $instance = $conn->getInstance();    
        try {
            $sql = "SELECT * FROM user WHERE email = :email";
            $stmt = $instance->prepare($sql);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->execute();


 
        } catch(PDOException $e){
            die("Erro: ". $e->getMessage());
        }
    }
}

class emailRec {
    public function EmailRec($email) {
        $conn = new usePDO();
        $instance = $conn->getInstance();
        try {
            $sql = "SELECT * FROM user WHERE email = :email";
            $stmt = $instance->prepare($sql);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                $user = $stmt->fetch(PDO::FETCH_ASSOC);
                $code = mt_rand(100000, 999999);


                $sqlInsert = "INSERT INTO code (username, code, email, userID, lido) VALUES (:username, :code, :email, :userID, 0)";
                $stmtInsert = $instance->prepare($sqlInsert);
                $stmtInsert->bindParam(':username', $user['username'], PDO::PARAM_STR);
                $stmtInsert->bindParam(':code', $code, PDO::PARAM_STR);
                $stmtInsert->bindParam(':email', $email, PDO::PARAM_STR);
                $stmtInsert->bindParam(':userID', $user['userID'], PDO::PARAM_INT);
                $stmtInsert->execute();
                $_SESSION['emailrec'] = $user;
                $_SESSION['codigo_enviado'] = $code; 
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            die("Erro: " . $e->getMessage());
        }
    }
}