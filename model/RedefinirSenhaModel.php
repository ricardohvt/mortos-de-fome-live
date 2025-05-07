<?php

require '../service/conexao.php';

class RedefinirSenha {
    public function atualizarSenha($userID, $novaSenha) {
        $conn = new usePDO();
        $instance = $conn->getInstance();

        try {
            $hashedPassword = password_hash($novaSenha, PASSWORD_DEFAULT);
            $sql = "UPDATE user SET password_main = :senha WHERE userID = :userID";
            $stmt = $instance->prepare($sql);
            $stmt->bindParam(':senha', $hashedPassword, PDO::PARAM_STR);
            $stmt->bindParam(':userID', $userID, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            die("Erro: " . $e->getMessage());
        }
    }
}