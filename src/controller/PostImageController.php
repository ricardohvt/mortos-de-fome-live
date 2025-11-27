<?php
session_start();
require_once '../service/conexao.php';

function ensureAuthForPost(mysqli $con, int $postID): bool {
  if (!isset($_SESSION['user']['userID'])) return false;
  $isAdmin = intval($_SESSION['user']['isAdmin'] ?? 0) === 1;
  if ($isAdmin) return true;
  $uid = intval($_SESSION['user']['userID']);
  $stmt = $con->prepare('SELECT 1 FROM post WHERE postID=? AND userID=?');
  $stmt->bind_param('ii', $postID, $uid);
  $stmt->execute();
  $stmt->store_result();
  $ok = $stmt->num_rows > 0;
  $stmt->close();
  return $ok;
}

$con = instance2();
$method = $_SERVER['REQUEST_METHOD'];
$action = $_REQUEST['action'] ?? '';

if ($method === 'GET' && $action === 'list') {
  header('Content-Type: application/json; charset=utf-8');
  $postID = intval($_GET['postID'] ?? 0);
  if ($postID <= 0 || !ensureAuthForPost($con, $postID)) {
    http_response_code(403);
    echo json_encode(['ok' => false, 'error' => 'forbidden']);
    $con->close();
    exit;
  }
  $stmt = $con->prepare('SELECT post_imagesID, image FROM post_images WHERE PostID=? ORDER BY post_imagesID ASC');
  $stmt->bind_param('i', $postID);
  $stmt->execute();
  $res = $stmt->get_result();
  $items = [];
  while ($res && ($row = $res->fetch_assoc())) {
    $items[] = [
      'id' => intval($row['post_imagesID']),
      'b64' => 'data:image/jpeg;base64,' . base64_encode($row['image'])
    ];
  }
  $stmt->close();
  echo json_encode(['ok' => true, 'items' => $items]);
  $con->close();
  exit;
}

if ($method === 'POST' && $action === 'delete') {
  $imgID = intval($_POST['post_imagesID'] ?? 0);
  if ($imgID <= 0) { http_response_code(400); echo 'Bad Request'; exit; }

  // obter PostID da imagem e validar permissão
  $stmt = $con->prepare('SELECT PostID FROM post_images WHERE post_imagesID=?');
  $stmt->bind_param('i', $imgID);
  $stmt->execute();
  $stmt->bind_result($postID);
  if (!$stmt->fetch()) { $stmt->close(); http_response_code(404); echo 'Not Found'; exit; }
  $stmt->close();

  if (!ensureAuthForPost($con, intval($postID))) { http_response_code(403); echo 'Forbidden'; exit; }

  $stmt = $con->prepare('DELETE FROM post_images WHERE post_imagesID=?');
  $stmt->bind_param('i', $imgID);
  $ok = $stmt->execute();
  $stmt->close();
  $con->close();

  if ($ok) {
    $_SESSION['success'] = 'Imagem removida.';
  } else {
    $_SESSION['error'] = 'Falha ao remover imagem.';
  }
  header('Location: ' . ($_POST['redirect'] ?? '../view/painel.php?tab=postagens'));
  exit;
}

if ($method === 'POST' && $action === 'add') {
  $postID = intval($_POST['postID'] ?? 0);
  if ($postID <= 0 || !ensureAuthForPost($con, $postID)) {
    $_SESSION['error'] = 'Sem permissão.';
    header('Location: ' . ($_POST['redirect'] ?? '../view/painel.php?tab=postagens'));
    exit;
  }
  $okAny = false;
  if (!empty($_FILES['images']['name'][0])) {
    foreach ($_FILES['images']['tmp_name'] as $k => $tmp) {
      if (isset($_FILES['images']['error'][$k]) && $_FILES['images']['error'][$k] === UPLOAD_ERR_OK && is_uploaded_file($tmp)) {
        $data = file_get_contents($tmp);
        $stmt = $con->prepare('INSERT INTO post_images (PostID, image) VALUES (?, ?)');
        $stmt->bind_param('ib', $postID, $data);
        $stmt->send_long_data(1, $data);
        $ok = $stmt->execute();
        $stmt->close();
        if ($ok) { $okAny = true; }
      }
    }
  }
  $con->close();
  $_SESSION[$okAny ? 'success' : 'error'] = $okAny ? 'Imagens adicionadas.' : 'Nenhuma imagem foi adicionada.';
  header('Location: ' . ($_POST['redirect'] ?? '../view/painel.php?tab=postagens'));
  exit;
}

http_response_code(400);
echo 'Bad Request';
$con->close();
