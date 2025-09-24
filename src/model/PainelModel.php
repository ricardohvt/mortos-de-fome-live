    <?php
    // Arquivo com funções para manipulação de dados
    include_once '../service/conexao.php';


    $conexao = instance2();
    // Função para buscar todos os Post
    function buscarPost($conexao) {
        $Post = array();
        
        // Query para buscar Post ordenados por data (mais recentes primeiro)
        $sql = "SELECT * FROM post";
        $resultado = $conexao->query($sql);
        if ($resultado && $resultado->num_rows > 0) {
            while ($row = $resultado->fetch_assoc()) {
                $Post[] = $row;
            }
        }
        
        return $Post;
    }
    $posts = buscarPost($conexao);
    echo "<pre>";
    var_dump($posts);
    echo "</pre>";
    ?>

