<?php
include_once '../service/conexao.php';

function buscarPost($conexao) {
    $posts = array();
    $sql = "SELECT p.*, u.username, c.descricao_categoria 
            FROM post p 
            LEFT JOIN user u ON p.userID = u.userID 
            LEFT JOIN categoria_post c ON p.categoria_postID = c.categoria_postID 
            ORDER BY p.criado_em DESC";
    $resultado = $conexao->query($sql);
    
    if ($resultado && $resultado->num_rows > 0) {
        while ($row = $resultado->fetch_assoc()) {
            $posts[] = $row;
        }
    }
    
    return $posts;
}






?>