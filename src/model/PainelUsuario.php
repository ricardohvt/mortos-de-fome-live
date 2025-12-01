<?php
require '../service/conexao.php';
session_start();


if (!isset($_SESSION['user']['userID'])) {
    header('Location: ../view/login-index.php');
    exit;
}

$userid = $_SESSION['user']['userID'];

function buscarPostPorUsuario($conexao, $userid) {
    $receitas = array();
    
    
    $sql = "SELECT p.*, c.descricao_categoria 
            FROM post p 
            LEFT JOIN categoria_post c ON p.categoria_postID = c.categoria_postID 
            WHERE p.userID = ? 
            ORDER BY p.criado_em DESC";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("i", $userid);
    $stmt->execute();
    $resultado = $stmt->get_result();
    
    if ($resultado && $resultado->num_rows > 0) {
        while ($row = $resultado->fetch_assoc()) {
            $receitas[] = $row;
        }
    }
    
    $stmt->close();
    return $receitas;
}


$Posts = buscarPostPorUsuario(instance2(), $userid);


if (isset($_GET['debug']) && $_GET['debug'] == 1) {
    echo "<pre>";
    var_dump($Posts);
    echo "</pre>";
}
?>