<?php  
session_start();    
include 'db.php'; // mysqli connection

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if (isset($_GET['id'])) {
    $task_id = $_GET['id'];

    // select statement
    $stmt = $connection->prepare("SELECT * FROM tasks WHERE id = ?");
    $stmt->bind_param("i", $task_id); // 'i' for integer
    $stmt->execute();
    $result = $stmt->get_result();
    $task = $result->fetch_assoc();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $due_date = trim($_POST['due_date']);
    $priority = trim($_POST['priority']);
    $status = trim($_POST['status']);

    // the update statement
    $stmt = $connection->prepare("UPDATE tasks SET title = ?, description = ?, due_date = ?, priority = ?, status = ? WHERE id = ?");
    $stmt->bind_param("sssssi", $title, $description, $due_date, $priority, $status, $task_id); // 's' for string, 'i' for integer
    $stmt->execute();

    header("Location: dashboard.php");
    exit();
}

$stmt->close(); // Close the statement
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Task</title>
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
            font-size: 20px;
            margin: 80px auto; 
            padding: 20px;
            background-color: #fff; 
            border-radius: 15px; 
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2); 
            border: 3px dashed #ff9800;
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #ff4081; 
        }
        input, textarea, select {
            width: 100%;
            font-size: 17px;
            padding: 10px;
            margin: 10px 0;
            border-radius: 10px;
            border: 2px solid #81d4fa; 
            background-color: #e1f5fe; 
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); 
            transition: border 0.3s; 
        }
        input:focus, textarea:focus, select:focus {
            border-color: #ff5722; 
            outline: none; 
        }
        button {
            width: 100%;
            padding: 10px;
            background-color: #4caf50; 
            color: white;
            border: none;
            border-radius: 10px; 
            font-size: 20px; 
            cursor: pointer;
            transition: background-color 0.3s ease; 
        }
        button:hover {
            background-color: #388e3c; 
        }

        select {
            background-color: #ffe0b2; 
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <a href="dashboard.php">Task Manager</a>
        <a href="add_task.php">Add Task</a>
        <a href="dashboard.php">Dashboard</a>
        <a href="logout.php">Logout</a>
    </nav>

    <div class="container">
        <form method="POST" action="">
            <h2>Edit Task</h2>
            <input type="text" name="title" value="<?php echo htmlspecialchars($task['title']); ?>" required>
            <textarea name="description" rows="4"><?php echo htmlspecialchars($task['description']); ?></textarea>
            <input type="date" name="due_date" value="<?php echo htmlspecialchars($task['due_date']); ?>" required>
            <select name="priority" required>
                <option value="" disabled>Select Priority</option>
                <option value="Low" <?php if ($task['priority'] == 'Low') echo 'selected'; ?>>Low</option>
                <option value="Medium" <?php if ($task['priority'] == 'Medium') echo 'selected'; ?>>Medium</option>
                <option value="High" <?php if ($task['priority'] == 'High') echo 'selected'; ?>>High</option>
            </select>
            <select name="status" required>
                <option value="" disabled>Select Status</option>
                <option value="Pending" <?php if ($task['status'] == 'Pending') echo 'selected'; ?>>Pending</option>
                <option value="In Progress" <?php if ($task['status'] == 'In Progress') echo 'selected'; ?>>In Progress</option>
                <option value="Completed" <?php if ($task['status'] == 'Completed') echo 'selected'; ?>>Completed</option>
            </select>
            <button type="submit">Update Task</button>
        </form>
    </div>
</body>
</html>
