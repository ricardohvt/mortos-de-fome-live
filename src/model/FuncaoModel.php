<?php
// Arquivo com funções para manipulação de dados
include_once '../service/conexao.php';



// Função para buscar todos os emails
function buscarEmails($conexao) {
    $emails = array();
    
    // Query para buscar emails ordenados por data (mais recentes primeiro)
    $sql = "SELECT * FROM code";
    $resultado = $conexao->query($sql);
    if ($resultado && $resultado->num_rows > 0) {
        while ($row = $resultado->fetch_assoc()) {
            $emails[] = $row;
        }
    }
    
    return $emails;
}

// Função para buscar um email específico pelo ID
function buscarEmailPorId($conexao, $id) {
    // Query para buscar um email específico
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

// Função para marcar um email como lido
function marcarComoLido($conexao, $id) {
    $sql = "UPDATE code SET lido = 1 WHERE lido = ?";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("i", $id);
    return $stmt->execute();
}

// Função para formatar a data
function formatarData($data) {
    $timestamp = strtotime($data);
    return date('d/m/Y', $timestamp);
}
?>