<?php

require '../service/conexao.php';

class RecuperacaoCodigo {
    public function validarCodigo($codigo, $email) {
        $conn = new usePDO();
        $instance = $conn->getInstance();

        try {
            $sql = "SELECT * FROM code WHERE code = :codigo AND email = :email AND lido = 0";
            $stmt = $instance->prepare($sql);
            $stmt->bindParam(':codigo', $codigo, PDO::PARAM_STR);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                $sqlUpdate = "UPDATE code SET lido = 1 WHERE code = :codigo AND email = :email";
                $stmtUpdate = $instance->prepare($sqlUpdate);
                $stmtUpdate->bindParam(':codigo', $codigo, PDO::PARAM_STR);
                $stmtUpdate->bindParam(':email', $email, PDO::PARAM_STR);
                $stmtUpdate->execute();
                return true;
            }
            return false;
        } catch (PDOException $e) {
            die("Erro: " . $e->getMessage());
        }
    }
}