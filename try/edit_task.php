<?php  
session_start();    
include 'db.php'; // Ensure this file has the correct mysqli connection

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if (isset($_GET['id'])) {
    $task_id = $_GET['id'];

    // Prepare and execute the select statement
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

    // Prepare and execute the update statement
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
            font-family: 'Comic Sans MS', cursive, sans-serif; /* Fun font for kids */
            background-color: #f0f4c3; /* Light green background */
            color: #333;
            margin: 0; /* Reset default margin */
            padding: 0; /* Reset default padding */
        }
        .navbar {
            background: linear-gradient(135deg, #2196F3, #64B5F6); /* Blue gradient */
            padding: 10px; /* Padding for navbar */
            position: fixed; /* Fixed position for navbar */
            width: 100%; /* Full width */
            top: 0; /* Stick to top */
            z-index: 1000; /* On top of other elements */
        }
        .navbar a {
            color: white; /* White text */
            font-size: 1.5rem; /* Increased font size for navbar */
            margin-right: 20px; /* Spacing between links */
            text-decoration: none; /* No underline */
        }
        .container {
            max-width: 600px;
            font-size: 20px;
            margin: 80px auto; /* Space for fixed navbar */
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
        input, textarea, select {
            width: 100%;
            font-size: 17px;
            padding: 10px;
            margin: 10px 0;
            border-radius: 10px;
            border: 2px solid #81d4fa; /* Bright blue border */
            background-color: #e1f5fe; /* Light blue background for input */
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); /* Input shadow */
            transition: border 0.3s; /* Smooth transition for focus */
        }
        input:focus, textarea:focus, select:focus {
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
            font-size: 20px; /* Larger font size */
            cursor: pointer;
            transition: background-color 0.3s ease; /* Smooth transition */
        }
        button:hover {
            background-color: #388e3c; /* Darker green on hover */
        }
        /* Colorful dropdowns */
        select {
            background-color: #ffe0b2; /* Light peach background for select */
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
