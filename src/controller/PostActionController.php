<?php
session_start();
include_once '../service/conexao.php';

if (!isset($_SESSION['user']['isAdmin']) || $_SESSION['user']['isAdmin'] != 1) {
    header("Location: ../view/login-index.php");
    exit();
}

$conexao = instance2();

$action = $_POST['action'] ?? '';
$postID = intval($_POST['postID'] ?? 0);

if ($postID <= 0) {
    $_SESSION['error'] = "ID inválido.";
    header("Location: ../view/painel.php");
    exit();
}

switch ($action) {
    case 'aprovar':
        $sql = "UPDATE post SET autorizado = 1 WHERE postID = ?";
        break;
    case 'revogar':
        $sql = "UPDATE post SET autorizado = 0 WHERE postID = ?";
        break;
    case 'excluir':
        $sql = "DELETE FROM post WHERE postID = ?";
        break;
    case 'editar':
        $titulo = trim($_POST['nome_post'] ?? '');
        $descricao = trim($_POST['descricao_post'] ?? '');
        $ingredientes = trim($_POST['ingredientes'] ?? '');
        $modo = trim($_POST['modoPreparo'] ?? '');
        $categoria = intval($_POST['categoria_postID'] ?? 0);
        
        // Validar limite de caracteres
        if (strlen($descricao) > 500) {
            $_SESSION['error'] = "Descrição não pode exceder 500 caracteres.";
            header("Location: ../view/painel.php");
            exit();
        }
        
        $sql = "UPDATE post SET nome_post=?, descricao_post=?, ingredients=?, modoPreparo=?, categoria_postID=? WHERE postID=?";
        $stmt = $conexao->prepare($sql);
        $stmt->bind_param("ssssii", $titulo, $descricao, $ingredientes, $modo, $categoria, $postID);
        $ok = $stmt->execute();
        $stmt->close();
        $_SESSION[$ok ? 'success' : 'error'] = $ok ? "Post atualizado." : "Falha ao editar.";
        header("Location: ../view/painel.php");
        exit();
    default:
        $_SESSION['error'] = "Ação inválida.";
        header("Location: ../view/painel.php");
        exit();
}

$stmt = $conexao->prepare($sql);
$stmt->bind_param("i", $postID);
$ok = $stmt->execute();
$stmt->close();
$conexao->close();

$_SESSION[$ok ? 'success' : 'error'] = $ok ? "Ação executada." : "Erro na operação.";
header("Location: ../view/painel.php");
exit();
?>
