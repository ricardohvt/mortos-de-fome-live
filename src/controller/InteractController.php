<?php
session_start();
require_once '../service/conexao.php';

if (!isset($_SESSION['user']['userID'])) {
  $_SESSION['error'] = 'Faça login para interagir.';
  header('Location: ../view/login-index.php');
  exit;
}

$action = $_POST['action'] ?? '';
$postID = intval($_POST['postID'] ?? 0);
if ($postID <= 0) {
  header('Location: ../view/index.php');
  exit;
}

$con = instance2();

// Garantir que o post existe e está autorizado
$okPost = false;
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

function redirectBack($postID) {
  header('Location: ../view/post.php?id=' . $postID);
  exit;
}

try {
  switch ($action) {
    case 'like':
      // toggle like
      $stmt = $con->prepare('SELECT 1 FROM user_likes WHERE userID=? AND postID=?');
      $stmt->bind_param('ii', $userID, $postID);
      $stmt->execute();
      $stmt->store_result();
      $exists = $stmt->num_rows > 0;
      $stmt->close();

      if ($exists) {
        $stmt = $con->prepare('DELETE FROM user_likes WHERE userID=? AND postID=?');
        $stmt->bind_param('ii', $userID, $postID);
        $stmt->execute();
        $stmt->close();
        $_SESSION['success'] = 'Removido dos seus curtidos.';
      } else {
        $stmt = $con->prepare('INSERT INTO user_likes (userID, postID) VALUES (?, ?)');
        $stmt->bind_param('ii', $userID, $postID);
        $stmt->execute();
        $stmt->close();
        $_SESSION['success'] = 'Você curtiu este post!';
      }
      redirectBack($postID);
      break;

    case 'favorite':
      // toggle favorite
      $stmt = $con->prepare('SELECT 1 FROM user_favoritos WHERE userID=? AND postID=?');
      $stmt->bind_param('ii', $userID, $postID);
      $stmt->execute();
      $stmt->store_result();
      $exists = $stmt->num_rows > 0;
      $stmt->close();

      if ($exists) {
        $stmt = $con->prepare('DELETE FROM user_favoritos WHERE userID=? AND postID=?');
        $stmt->bind_param('ii', $userID, $postID);
        $stmt->execute();
        $stmt->close();
        $_SESSION['success'] = 'Removido dos favoritos.';
      } else {
        $stmt = $con->prepare('INSERT INTO user_favoritos (userID, postID) VALUES (?, ?)');
        $stmt->bind_param('ii', $userID, $postID);
        $stmt->execute();
        $stmt->close();
        $_SESSION['success'] = 'Adicionado aos favoritos!';
      }
      redirectBack($postID);
      break;

    default:
      $_SESSION['error'] = 'Ação inválida.';
      redirectBack($postID);
  }
} finally {
  $con->close();
}
