<?php
session_start();
require_once '../service/conexao.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  header('Location: ../view/painel-usuario.php');
  exit;
}

if (!isset($_SESSION['user']['userID'])) {
  header('Location: ../view/login-index.php');
  exit;
}

$action = $_POST['action'] ?? '';
$postID = intval($_POST['postID'] ?? 0);
$con = instance2();
$uid = intval($_SESSION['user']['userID']);

function ownPost(mysqli $con, int $postID, int $uid): bool {
  $stmt = $con->prepare('SELECT 1 FROM post WHERE postID=? AND userID=?');
  $stmt->bind_param('ii', $postID, $uid);
  $stmt->execute();
  $stmt->store_result();
  $ok = $stmt->num_rows > 0;
  $stmt->close();
  return $ok;
}

switch ($action) {
  case 'editar':
    $titulo = trim($_POST['nome_post'] ?? '');
    $ingredientes = trim($_POST['ingredientes'] ?? '');
    $modo = trim($_POST['modoPreparo'] ?? '');
    $categoria = intval($_POST['categoria_postID'] ?? 0);
    if ($postID <= 0 || !ownPost($con, $postID, $uid)) { $_SESSION['error'] = 'Sem permissão.'; break; }
    $stmt = $con->prepare('UPDATE post SET nome_post=?, ingredients=?, modoPreparo=?, categoria_postID=? WHERE postID=? AND userID=?');
    $stmt->bind_param('sssiii', $titulo, $ingredientes, $modo, $categoria, $postID, $uid);
    $ok = $stmt->execute();
    $stmt->close();
    $_SESSION[$ok ? 'success' : 'error'] = $ok ? 'Post atualizado.' : 'Falha ao editar.';
    break;

  case 'excluir':
    if ($postID <= 0 || !ownPost($con, $postID, $uid)) { $_SESSION['error'] = 'Sem permissão.'; break; }
    // cascade apaga imagens; apenas apaga o post do próprio usuário
    $stmt = $con->prepare('DELETE FROM post WHERE postID=? AND userID=?');
    $stmt->bind_param('ii', $postID, $uid);
    $ok = $stmt->execute();
    $stmt->close();
    $_SESSION[$ok ? 'success' : 'error'] = $ok ? 'Post excluído.' : 'Falha ao excluir.';
    break;

  default:
    $_SESSION['error'] = 'Ação inválida.';
}

$con->close();
header('Location: ../view/painel-usuario.php?tab=postagens');
exit;