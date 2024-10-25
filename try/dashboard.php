<?php
session_start();
include 'db.php'; // Include your database connection file

// Check if user is logged in or not
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$search_query = '';
$order_by = 'priority'; 
$sort_priority = false; 

// Check if a search or sort is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['search'])) {
        $search_query = trim($_POST['search']);
    }

    // Check if sort button was clicked
    if (isset($_POST['sort_priority'])) {
        $sort_priority = true; 
    }
}

$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM tasks WHERE user_id = ? AND title LIKE ?";

if ($sort_priority) {
    $sql .= " ORDER BY 
        CASE 
            WHEN priority = 'High' THEN 1 
            WHEN priority = 'Medium' THEN 2 
            WHEN priority = 'Low' THEN 3 
            ELSE 4 
        END ASC, title ASC"; // Sort by priority
} else {
    $sql .= " ORDER BY due_date ASC"; 
}

$stmt = $connection->prepare($sql);
$like_query = "%$search_query%";
$stmt->bind_param("is", $user_id, $like_query); // "is" for integer and string
$stmt->execute();
$result = $stmt->get_result();
$tasks = $result->fetch_all(MYSQLI_ASSOC); // Fetch data as an array

$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Dashboard</title>
    <style>
        /*styles */
        body {
            font-family: 'Comic Sans MS', cursive, sans-serif; 
            background-color: #e3f2fd;
            margin: 0;
            padding: 0;
            color: #333; 
            padding-top: 70px; 
            font-size: 20px; 
            display: flex; 
            flex-direction: column; 
            align-items: center; 
        }

        .navbar {
            background: linear-gradient(135deg, #2196F3, #90caf9); 
            position: fixed;
            width: 100%;
            top: 0;
            left: 0;
            padding: 15px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); 
            z-index: 1000; 
        }

        .navbar a {
            color: #ffeb3b; 
            text-decoration: none; 
            padding: 10px 20px; 
            font-size: 22px; 
            margin-right: 15px;
        }

        .navbar a:hover {
            background-color: rgba(255, 255, 255, 0.2); 
            border-radius: 10px; 
        }

        .navbar-brand {
            font-weight: bold; 
            font-size: 24px; 
            color: #ffeb3b;
        }

        /* Table Styles */
        table {
            width: 110%; 
            border-collapse: collapse;
            margin-top: 20px; 
            border: 2px solid #2196F3; 
            background-color: #ffffff; 
            text-align: center;
        }

        th, td {
            padding: 15px;
            border-bottom: 2px solid #90caf9; 
            font-size: 20px; 
        }

        th {
            background-color: #64b5f6; 
            color: #ffffff; 
            font-size: 24px; 
        }

        tr:hover {
            background-color: #e1f5fe; 
        }

        .edit-btn, .delete-btn {
            color: white; 
            padding: 8px 15px;
            border-radius: 10px; 
            text-decoration: none; 
            font-size: 18px; 
            margin-right: 5px; 
        }

        .edit-btn {
            background-color: #4caf50; 
        }

        .edit-btn:hover {
            background-color: #388e3c; 
        }

        .delete-btn {
            background-color: #f44336; 
        }

        .delete-btn:hover {
            background-color: #c62828; 
        }

        .search-bar {
            margin: 20px 0; 
            display: flex; 
            justify-content: center;
            align-items: center; 
        }

        .search-bar input[type="text"] {
            border: 2px solid #2196F3; 
            padding: 10px; 
            font-size: 18px; 
            border-radius: 5px; 
            width: calc(200% - 120px); 
            margin-right: 10px; 
        }

        .search-bar button {
            background-color: #2196F3; 
            border: 2px solid #2196F3; 
            color: white; 
            padding: 10px 15px;
            width: 20%;
            font-size: 18px;
            border-radius: 5px;
            cursor: pointer; 
        }

        .search-bar button:hover {
            background-color: #1976D2; 
        }

        
        .search-bar button[name="sort_priority"] {
            background-color: #2196F3; 
            border: 2px solid #2196F3; 
            color: white; 
            padding: 10px 15px;
            width: 30%; 
            font-size: 18px;
            border-radius: 5px;
            cursor: pointer; 
            transition: background-color 0.3s, transform 0.3s; 
        }

        .search-bar button[name="sort_priority"]:hover {
            background-color: #f57c00; 
            transform: scale(1.05); 
        }

        .highlight {
            background-color: #ffeb3b; 
            border: 2px solid #ff9800;
        }

        .container h3 {
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="navbar">
        <span class="navbar-brand">Fun Task Manager</span>
        <a href="add_task.php"><i class="fas fa-plus-circle"></i> Add Task</a>
        <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
    </div>

    <div class="container">
        <h3>Your Tasks</h3>
        
        <!-- Search Bar -->
        <form method="POST" class="search-bar">
            <input type="text" name="search" placeholder="Search for fun tasks..." value="<?php echo htmlspecialchars($search_query); ?>">
            <button type="submit"><i class="fas fa-search"></i> Search</button> <!-- submit -->
            <button type="submit" name="sort_priority"><i class="fas fa-sort"></i> Sort by Priority</button> <!-- Sort button -->
        </form>

        <table>
            <tr>
                <th>Title</th>
                <th>Description</th>
                <th>Due Date</th>
                <th>Status</th>
                <th>Priority</th>
                <th>Actions</th>
            </tr>
            <?php foreach ($tasks as $task): ?>
            <tr class="<?php echo $task['priority'] === 'High' ? 'highlight' : ''; ?>">
                <td><?php echo htmlspecialchars($task['title']); ?></td>
                <td><?php echo htmlspecialchars($task['description']); ?></td>
                <td><?php echo htmlspecialchars($task['due_date']); ?></td>
                <td><?php echo htmlspecialchars($task['status']); ?></td>
                <td><?php echo htmlspecialchars($task['priority']); ?></td>
                <td>
                    <a href="edit_task.php?id=<?php echo $task['id']; ?>" class="edit-btn"><i class="fas fa-edit"></i> Edit</a>
                    <a href="delete_task.php?id=<?php echo $task['id']; ?>" class="delete-btn"><i class="fas fa-trash"></i> Delete</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
    </div>

    <!-- Icons -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js"></script>
</body>
</html>
