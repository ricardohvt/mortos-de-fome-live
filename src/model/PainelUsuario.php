<?php
require '../service/conexao.php';
session_start();

$userid = $_SESSION['user']['id'] ?? null;

function buscarPostPorUsuario($conexao, $userid) {
    $receitas = array();
    
    // para buscar receitas do usuário logado
    $sql = "SELECT * FROM post WHERE userId = ?";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("i", $userid);
    $stmt->execute();
    $resultado = $stmt->get_result();
    
    if ($resultado && $resultado->num_rows > 0) {
        while ($row = $resultado->fetch_assoc()) {
            $receitas[] = $row;
        }
    }
    
    return $receitas;
}

$Posts = buscarPostPorUsuario(instance2(), $userid);
echo "<pre>";
var_dump($Posts);
?>