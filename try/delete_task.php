<?php
session_start();
include 'db.php'; 

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if (isset($_GET['id'])) {
    $task_id = $_GET['id'];

    // execute the delete statement
    $stmt = $connection->prepare("DELETE FROM tasks WHERE id = ?");
    $stmt->bind_param("i", $task_id); // 'i' for integer
    $stmt->execute();

    // Check if delete was successful
    if ($stmt->affected_rows > 0) {
        $_SESSION['message'] = "Task deleted successfully.";
    } else {
        $_SESSION['error'] = "Task could not be deleted.";
    }

    header("Location: dashboard.php");
    exit();
}
?>
