<?php
session_start();
require_once '../service/conexao.php';

if (!isset($_SESSION['user']['isAdmin']) || intval($_SESSION['user']['isAdmin']) !== 1) {
  header('Location: ../view/login-index.php');
  exit;
}

$method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
$action = $_POST['action'] ?? $_GET['action'] ?? '';

$con = instance2();

function redirectBack($tab = 'postagens') {
  header('Location: ../view/painel.php?tab=' . $tab);
  exit;
}

if ($method === 'POST') {
  switch ($action) {
    case 'create':
      $descricao = trim($_POST['descricao_categoria'] ?? '');
      if ($descricao === '') {
        $_SESSION['error'] = 'Informe o nome da categoria.';
        redirectBack();
      }
      
      $stmt = $con->prepare('SELECT 1 FROM categoria_post WHERE descricao_categoria = ? LIMIT 1');
      $stmt->bind_param('s', $descricao);
      $stmt->execute();
      $stmt->store_result();
      if ($stmt->num_rows > 0) {
        $stmt->close();
        $_SESSION['error'] = 'Já existe uma categoria com esse nome.';
        redirectBack();
      }
      $stmt->close();

      $stmt = $con->prepare('INSERT INTO categoria_post (descricao_categoria) VALUES (?)');
      $stmt->bind_param('s', $descricao);
      $ok = $stmt->execute();
      $stmt->close();
      $_SESSION[$ok ? 'success' : 'error'] = $ok ? 'Categoria criada.' : 'Falha ao criar categoria.';
      redirectBack();

    case 'rename':
      $id = intval($_POST['categoria_postID'] ?? 0);
      $descricao = trim($_POST['descricao_categoria'] ?? '');
      if ($id <= 0 || $descricao === '') {
        $_SESSION['error'] = 'Dados inválidos.';
        redirectBack();
      }
      $stmt = $con->prepare('UPDATE categoria_post SET descricao_categoria=? WHERE categoria_postID=?');
      $stmt->bind_param('si', $descricao, $id);
      $ok = $stmt->execute();
      $stmt->close();
      $_SESSION[$ok ? 'success' : 'error'] = $ok ? 'Categoria renomeada.' : 'Falha ao renomear.';
      redirectBack();

    default:
      $_SESSION['error'] = 'Ação inválida.';
      redirectBack();
  }
}

redirectBack();
