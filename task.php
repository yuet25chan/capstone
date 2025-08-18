<?php
session_start();
include 'db_credentials.php';

// minimal: get user_id for inserts
$userId = isset($_SESSION['user_id']) ? (int)$_SESSION['user_id'] : 0;

switch($_POST['action']) {
    case 'add':
        // minimal fix: include user_id in insert
        $sql = "INSERT INTO tasks (user_id, title, description, due_date, priority, status, category)
                VALUES ({$userId}, '{$_POST['title']}', '{$_POST['description']}', '{$_POST['due_date']}', '{$_POST['priority']}', '{$_POST['status']}', '{$_POST['category']}')";

        if (mysqli_query($conn, $sql)) {
            $_SESSION['alert']="taskadded";
            header("Location: dashboard.php");
            die;
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
        mysqli_close($conn);
        break;

    case 'edit':
    $stmt = $conn->prepare(
        'UPDATE tasks
           SET title=?, description=?, due_date=?, priority=?, status=?, category=?
         WHERE task_id=? AND user_id=?'
    );
    $stmt->bind_param(
        'ssssssii',
        $_POST['title'],
        $_POST['description'],
        $_POST['due_date'],
        $_POST['priority'],
        $_POST['status'],
        $_POST['category'],
        (int)$_POST['task_id'],
        $userId
    );

    if ($stmt->execute()) {
        $_SESSION['alert'] = 'taskupdated';
        header('Location: dashboard.php'); exit;
    } else {
        echo 'Error updating record: ' . $stmt->error;
    }
    $stmt->close();
    $conn->close();
    break;

    case 'delete':
    $stmt = $conn->prepare('DELETE FROM tasks WHERE task_id=? AND user_id=?');
    $stmt->bind_param('ii', (int)$_POST['task_id'], $userId);

    if ($stmt->execute()) {
        $_SESSION['alert'] = 'taskdeleted';
        header('Location: dashboard.php'); exit;
    } else {
        echo 'Error deleting record: ' . $stmt->error;
    }
    $stmt->close();
    $conn->close();
    break;
}
?>