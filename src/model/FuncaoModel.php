<?php

include_once '../service/conexao.php';




function buscarEmails($conexao) {
    $emails = array();
    
    
    $sql = "SELECT * FROM code";
    $resultado = $conexao->query($sql);
    if ($resultado && $resultado->num_rows > 0) {
        while ($row = $resultado->fetch_assoc()) {
            $emails[] = $row;
        }
    }
    
    return $emails;
}


function buscarEmailPorId($conexao, $id) {
    
    $sql = "SELECT * FROM code WHERE codeID = ?";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $resultado = $stmt->get_result();
    
    if ($resultado && $resultado->num_rows > 0) {
        return $resultado->fetch_assoc();
    }
    
    return null;
}


function marcarComoLido($conexao, $id) {
    $sql = "UPDATE code SET lido = 1 WHERE lido = ?";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("i", $id);
    return $stmt->execute();
}


function formatarData($data) {
    $timestamp = strtotime($data);
    return date('d/m/Y', $timestamp);
}
?>