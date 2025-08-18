<?php
session_start();
include 'db_credentials.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if (method_exists($conn, 'set_charset')) {
        $conn->set_charset('utf8mb4');
    }

    // 1) Also select id
    $stmt = $conn->prepare("SELECT id, user_password FROM users WHERE username = ? LIMIT 1");
    $stmt->bind_param("s", $username);
    $stmt->execute();

    // 2) Bind id as well
    $stmt->bind_result($user_id, $hash);

    if ($stmt->fetch()) {
        if (password_verify($password, $hash)) {
            session_regenerate_id(true);
            // 3) Save user_id so dashboard/task.php can use it
            $_SESSION["user_id"]  = (int)$user_id;
            $_SESSION["username"] = $username;
            header("Location: dashboard.php");
            exit();
        } else {
            echo "Incorrect password.";
        }
    } else {
        echo "User not found.";
    }

    $stmt->close();
    $conn->close();
}