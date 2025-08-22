<?php
session_start();
include 'db_credentials.php';


// ini_set('display_errors',1); ini_set('display_startup_errors',1);
// error_reporting(E_ALL); mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$userId = (int)($_SESSION['user_id'] ?? 0);

if ($userId <= 0 && !empty($_SESSION['username'])) {
    $u = $_SESSION['username'];
    $stmt = $conn->prepare('SELECT id FROM users WHERE username=?'); 
    $stmt->bind_param('s', $u);
    $stmt->execute();
    $stmt->bind_result($resolvedId);
    if ($stmt->fetch()) {
        $userId = (int)$resolvedId;
        $_SESSION['user_id'] = $userId; 
    }
    $stmt->close();
}
if ($userId <= 0) { http_response_code(403); exit('Missing user_id in session'); }

$op = $_POST['action'] ?? $_POST['submit'] ?? '';

switch ($op) {
    case 'add': {
       
        $title       = $_POST['title'] ?? '';
        $description = $_POST['description'] ?? '';
        $due_date    = $_POST['due_date'] ?? '';
        $priority    = $_POST['priority'] ?? '';
        $status      = $_POST['status'] ?? '';
        $category    = $_POST['category'] ?? '';

        $stmt = $conn->prepare(
          'INSERT INTO tasks (user_id, title, description, due_date, priority, `status`, category)
           VALUES (?, ?, ?, ?, ?, ?, ?)'
        );
        $stmt->bind_param('issssss', $userId, $title, $description, $due_date, $priority, $status, $category);
        $stmt->execute();

        $_SESSION['alert'] = 'taskadded';
        header('Location: dashboard.php'); exit;
    }

    case 'edit': {
        // (remove the duplicate 'case edit' line you had)
        $taskId      = (int)($_POST['task_id'] ?? 0);
        $title       = $_POST['title'] ?? '';
        $description = $_POST['description'] ?? '';
        $due_date    = $_POST['due_date'] ?? '';
        $priority    = $_POST['priority'] ?? '';
        $status      = $_POST['status'] ?? '';
        $category    = $_POST['category'] ?? '';

        $stmt = $conn->prepare(
          'UPDATE tasks
              SET title=?, description=?, due_date=?, priority=?, `status`=?, category=?
            WHERE task_id=? AND user_id=?'
        );
        $stmt->bind_param('ssssssii', $title, $description, $due_date, $priority, $status, $category, $taskId, $userId);
        $stmt->execute();

        $_SESSION['alert'] = 'taskupdated';
        header('Location: dashboard.php'); exit;
    }

    case 'delete': {
        $taskId = (int)($_POST['task_id'] ?? 0);

        $stmt = $conn->prepare('DELETE FROM tasks WHERE task_id=? AND user_id=?');
        $stmt->bind_param('ii', $taskId, $userId);
        $stmt->execute();

        $_SESSION['alert'] = 'taskdeleted';
        header('Location: dashboard.php'); exit;
    }

    default:
        http_response_code(400);
        exit('Unknown action');
}
