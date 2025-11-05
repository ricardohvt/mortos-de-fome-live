<?php
require '../service/conexao.php';
// Buscar categorias para o select
$categorias = array();
$sql_categorias = "SELECT * FROM categoria_post";
$result_categorias = $conexao->query($sql_categorias);

// DEBUG - Verificar o que está acontecendo
echo "<!-- DEBUG: Número de categorias encontradas: " . $result_categorias->num_rows . " -->";
if ($result_categorias && $result_categorias->num_rows > 0) {
    while ($row = $result_categorias->fetch_assoc()) {
        $categorias[] = $row;
        echo "<!-- DEBUG Categoria: ID=" . $row['categoria_postID'] . ", Nome=" . $row['descricao_categoria'] . " -->";
    }
} else {
    echo "<!-- DEBUG: Nenhuma categoria encontrada ou erro na query -->";
    echo "<!-- DEBUG Erro: " . $conexao->error . " -->";
}