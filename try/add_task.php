<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $due_date = trim($_POST['due_date']);
    $priority = trim($_POST['priority']);
    $status = trim($_POST['status']);
    $user_id = $_SESSION['user_id'];

    // Prepare and execute the insert statement
    $stmt = $connection->prepare("INSERT INTO tasks (user_id, title, description, due_date, priority, status) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("isssss", $user_id, $title, $description, $due_date, $priority, $status);

    if ($stmt->execute()) {
        header("Location: dashboard.php");
        exit();
    } else {
        echo "Error: " . $stmt->error; // Handle error
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Task</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"> <!-- Font Awesome for icons -->
    <style>
        body {
            font-family: 'Comic Sans MS', cursive, sans-serif; 
            background-color: #f0f4c3; 
            color: #333;
            margin: 0;
            padding: 0;
        }
        .navbar {
            background: linear-gradient(135deg, #2196F3, #64B5F6); 
            padding: 10px;
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
        }
        .navbar a {
            color: white; 
            font-size: 1.5rem; 
            margin-right: 20px; 
            text-decoration: none; 
        }
        .container {
            max-width: 600px;
            margin: 80px auto; 
            padding: 20px;
            background-color: #fff; /* White background for the form */
            border-radius: 15px; /* More rounded corners */
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2); /* Enhanced box shadow */
            border: 3px dashed #ff9800; /* Dashed border */
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #ff4081; /* Bright pink heading */
        }
        input, textarea {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border-radius: 10px;
            border: 2px solid #81d4fa; /* Bright blue border */
            background-color: #e1f5fe; /* Light blue background for input */
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); /* Input shadow */
            transition: border 0.3s; /* Smooth transition for focus */
        }
        input:focus, textarea:focus {
            border-color: #ff5722; /* Bright orange on focus */
            outline: none; /* Remove outline */
        }
        select {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border-radius: 10px;
            border: 2px solid #81d4fa; /* Bright blue border */
            background-color: #ffe0b2; /* Light peach background for select */
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); /* Input shadow */
            transition: border 0.3s; /* Smooth transition for focus */
        }
        select:focus {
            border-color: #ff5722; /* Bright orange on focus */
            outline: none; /* Remove outline */
        }
        button {
            width: 100%;
            padding: 10px;
            background-color: #4caf50; /* Bright green for button */
            color: white;
            border: none;
            border-radius: 10px; /* Rounded corners */
            font-size: 18px; /* Larger font size */
            cursor: pointer;
            transition: background-color 0.3s ease; /* Smooth transition */
        }
        button:hover {
            background-color: #388e3c; /* Darker green on hover */
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <a href="dashboard.php">Task Manager</a>
        <a href="add_task.php"><i class="fas fa-plus-circle"></i> Add Task</a>
        <a href="dashboard.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
        <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
    </nav>

    <div class="container">
        <form method="POST" action="">
            <h2>Add New Task</h2>
            <input type="text" name="title" placeholder="Title" required>
            <textarea name="description" placeholder="Description" rows="4"></textarea>
            <input type="date" name="due_date" required>
            <select name="priority" required>
                <option value="" disabled selected>Select Priority</option>
                <option value="Low">Low</option>
                <option value="Medium">Medium</option>
                <option value="High">High</option>
            </select>
            <select name="status" required>
                <option value="" disabled selected>Select Status</option>
                <option value="Pending">Pending</option>
                <option value="In Progress">In Progress</option>
                <option value="Completed">Completed</option>
            </select>
            <button type="submit"><i class="fas fa-check-circle"></i> Add Task</button>
        </form>
    </div>
</body>
</html>
