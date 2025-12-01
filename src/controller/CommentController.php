<?php
session_start();
require_once '../service/conexao.php';

if (!isset($_SESSION['user']['userID'])) {
  $_SESSION['error'] = 'Faça login para comentar.';
  header('Location: ../view/login-index.php');
  exit;
}

$postID = intval($_POST['postID'] ?? 0);
$comentario = trim($_POST['comentario'] ?? '');
if ($postID <= 0 || $comentario === '') {
  header('Location: ../view/index.php');
  exit;
}

$con = instance2();


$stmt = $con->prepare('SELECT 1 FROM post WHERE postID=? AND autorizado=1');
$stmt->bind_param('i', $postID);
$stmt->execute();
$stmt->store_result();
$okPost = $stmt->num_rows > 0;
$stmt->close();
if (!$okPost) {
  $_SESSION['error'] = 'Post indisponível.';
  header('Location: ../view/index.php');
  exit;
}

$userID = intval($_SESSION['user']['userID']);

$stmt = $con->prepare('INSERT INTO comentarios_post (userID, postID, comentario) VALUES (?, ?, ?)');
$stmt->bind_param('iis', $userID, $postID, $comentario);
$ok = $stmt->execute();
$stmt->close();
$con->close();

$_SESSION[$ok ? 'success' : 'error'] = $ok ? 'Comentário publicado.' : 'Não foi possível comentar.';
header('Location: ../view/post.php?id=' . $postID);
exit;