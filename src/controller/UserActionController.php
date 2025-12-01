<?php
session_start();
require_once '../service/conexao.php';


if (!isset($_SESSION['user']['isAdmin']) || intval($_SESSION['user']['isAdmin']) !== 1) {
    header('Location: ../view/login-index.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../view/painel.php?tab=usuarios');
    exit;
}

$action = $_POST['action'] ?? '';
$con = instance2();

function respond($ok, $msgOk, $msgErr) {
    $_SESSION[$ok ? 'success' : 'error'] = $ok ? $msgOk : $msgErr;
    header('Location: ../view/painel.php?tab=usuarios');
    exit;
}

try {
    switch ($action) {
        case 'create':
            $full_name = trim($_POST['full_name'] ?? '');
            $username  = trim($_POST['username'] ?? '');
            $email     = trim($_POST['email'] ?? '');
            $password  = trim($_POST['password'] ?? '');
            $isAdmin   = isset($_POST['isAdmin']) ? 1 : 0;

            if ($username === '' || $email === '' || $password === '') {
                respond(false, '', 'Preencha username, email e senha.');
            }

            
            $stmt = $con->prepare('SELECT 1 FROM `user` WHERE email = ? LIMIT 1');
            $stmt->bind_param('s', $email);
            $stmt->execute();
            $stmt->store_result();
            if ($stmt->num_rows > 0) {
                $stmt->close();
                respond(false, '', 'E-mail já cadastrado.');
            }
            $stmt->close();

            
            $pessoaID = null;
            if ($full_name !== '') {
                $stmt = $con->prepare('INSERT INTO pessoa (full_name) VALUES (?)');
                $stmt->bind_param('s', $full_name);
                if (!$stmt->execute()) {
                    $stmt->close();
                    respond(false, '', 'Erro ao criar pessoa.');
                }
                $pessoaID = $con->insert_id;
                $stmt->close();
            }

            $hash = password_hash($password, PASSWORD_DEFAULT);
            if ($pessoaID) {
                $stmt = $con->prepare('INSERT INTO `user` (username, email, password_main, pessoaID, isAdmin) VALUES (?, ?, ?, ?, ?)');
                $stmt->bind_param('sssii', $username, $email, $hash, $pessoaID, $isAdmin);
            } else {
                $stmt = $con->prepare('INSERT INTO `user` (username, email, password_main, isAdmin) VALUES (?, ?, ?, ?)');
                $stmt->bind_param('sssi', $username, $email, $hash, $isAdmin);
            }
            $ok = $stmt->execute();
            $stmt->close();
            respond($ok, 'Usuário criado com sucesso.', 'Falha ao criar usuário.');
            break;

        case 'update':
            $userID   = intval($_POST['userID'] ?? 0);
            $username = trim($_POST['username'] ?? '');
            $email    = trim($_POST['email'] ?? '');
            $isAdmin  = isset($_POST['isAdmin']) ? 1 : 0;
            $password = trim($_POST['password'] ?? ''); 

            if ($userID <= 0 || $username === '' || $email === '') {
                respond(false, '', 'Dados inválidos.');
            }

            
            $stmt = $con->prepare('SELECT 1 FROM `user` WHERE email = ? AND userID <> ? LIMIT 1');
            $stmt->bind_param('si', $email, $userID);
            $stmt->execute();
            $stmt->store_result();
            if ($stmt->num_rows > 0) {
                $stmt->close();
                respond(false, '', 'E-mail já utilizado por outro usuário.');
            }
            $stmt->close();

            if ($password !== '') {
                $hash = password_hash($password, PASSWORD_DEFAULT);
                $stmt = $con->prepare('UPDATE `user` SET username = ?, email = ?, isAdmin = ?, password_main = ? WHERE userID = ?');
                $stmt->bind_param('ssisi', $username, $email, $isAdmin, $hash, $userID);
            } else {
                $stmt = $con->prepare('UPDATE `user` SET username = ?, email = ?, isAdmin = ? WHERE userID = ?');
                $stmt->bind_param('ssii', $username, $email, $isAdmin, $userID);
            }
            $ok = $stmt->execute();
            $stmt->close();
            respond($ok, 'Usuário atualizado.', 'Falha ao atualizar usuário.');
            break;

        case 'delete':
            $userID = intval($_POST['userID'] ?? 0);
            if ($userID <= 0) {
                respond(false, '', 'ID inválido.');
            }
            
            if (isset($_SESSION['user']['userID']) && intval($_SESSION['user']['userID']) === $userID) {
                respond(false, '', 'Você não pode excluir a si mesmo.');
            }

            $stmt = $con->prepare('SELECT postID FROM post WHERE userID = ?');
            $stmt->bind_param('i', $userID);
            $stmt->execute();
            $result = $stmt->get_result();
            $postIDs = [];
            while ($row = $result->fetch_assoc()) { $postIDs[] = intval($row['postID']); }
            $stmt->close();

            if (!empty($postIDs)) {
                $in = implode(',', array_fill(0, count($postIDs), '?'));
                $types = str_repeat('i', count($postIDs));
                $stmt = $con->prepare("DELETE FROM post_images WHERE PostID IN ($in)");
                $stmt->bind_param($types, ...$postIDs);
                $stmt->execute();
                $stmt->close();

                $stmt = $con->prepare("DELETE FROM post WHERE postID IN ($in)");
                $stmt->bind_param($types, ...$postIDs);
                $stmt->execute();
                $stmt->close();
            }

            $stmt = $con->prepare('DELETE FROM code WHERE userID = ?');
            $stmt->bind_param('i', $userID);
            $stmt->execute();
            $stmt->close();

            $stmt = $con->prepare('DELETE FROM `user` WHERE userID = ?');
            $stmt->bind_param('i', $userID);
            $ok = $stmt->execute();
            $stmt->close();
            respond($ok, 'Usuário excluído.', 'Falha ao excluir usuário.');
            break;

        default:
            respond(false, '', 'Ação inválida.');
    }
} catch (Throwable $e) {
    error_log('UserActionController error: ' . $e->getMessage());
    respond(false, '', 'Erro inesperado.');
} finally {
    if (isset($con) && $con instanceof mysqli) {
        $con->close();
    }
}
