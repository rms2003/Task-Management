<?php
session_start();
include 'db.php'; // Database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    
    // Validate input
    $errors = [];
    if (empty($username)) {
        $errors[] = "Username is required.";
    }
    if (empty($password)) {
        $errors[] = "Password is required.";
    }

    // Check for errors
    if (empty($errors)) {
        // Prepare and execute SQL statement
        $stmt = $connection->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc(); // Fetch user data

        // Verify password
        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id']; 
            header("Location: dashboard.php"); // Redirect to dashboard
            exit();
        } else {
            $_SESSION['error'] = "Invalid username or password.";
        }
    } else {
        $_SESSION['error'] = implode("<br>", $errors);
    }
}

$connection->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        body {
            font-family: 'Comic Sans MS', cursive, sans-serif;
            background-color: #ffeb3b;
            margin: 0;
            color: #123456;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh; 
        }
        .container {
            display: flex;
            flex-wrap: wrap; 
            height: 70%;
            background-color: white;
            width: 95%;
            border-radius: 15px; 
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1); 
            overflow: hidden; 
        }
        .column {
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 30px;
            width: 50%; /* Equal space for both columns */
            height: 100%; 
        }
        .form-column {
            flex-grow: 1;
        }
        .image-column {
            justify-content: center;
            align-items: center;
            text-align: center;
            display: flex;
        }
        .image-column img {
            max-width: 100%;
            max-height: 100%;
            object-fit: cover; 
            border-radius: 15px; 
        }
        h2 {
            font-weight: bold;
            font-family: 'Comic Sans MS'; 
            text-align: center;
            color: #1974D2; 
        }
        .form-group {
            margin-bottom: 15px;
            font-size: 20px;
            font-family: 'Comic Sans MS'; 
        }
        .form-control {
            width: 100%; 
            padding: 10px; 
            border: 2px solid #ff5722; 
            border-radius: 8px; 
            background-color: #ffe0b2; 
            transition: border-color 0.3s; 
        }
        .form-control:focus {
            border-color: #1974D2; 
            outline: none; 
        }
        .error-message {
            color: red; 
            font-size: 16px; 
        }
        .btn {
            display: block; 
            margin: 20px auto; 
            background-color: #1974D2; 
            color: white; 
            border: none; 
            padding: 10px; 
            width: 40%; 
            cursor: pointer; 
            font-size: 20px; 
            border-radius: 8px; 
            transition: background-color 0.3s, transform 0.2s; 
        }
        .btn:hover {
            background-color: #0056b3;
            transform: scale(1.05); 
        }
    </style>
</head>

<body>
    <?php include 'navbar.php'; ?>
    <div class="container">
        <div class="column">
            <form method="POST" action="">
                <h2>Login</h2>
                <div class="form-group">
                    <label for="username">Username:</label>
                    <input type="text" name="username" class="form-control" placeholder="Username" required>
                </div>
                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" name="password" class="form-control" placeholder="Password" required>
                </div>

                <!-- Display error message -->
                <?php if (isset($_SESSION['error'])): ?>
                    <div class="error-message"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
                <?php endif; ?>
                
                <button type="submit" class="btn">Login</button>
                
                <button type="button" class="btn" onclick="window.location.href='register.php';">Register</button>
            </form>
        </div>
        <div class="column image-column">
            <img src="image1.png" alt="Decorative Image">
        </div>
    </div>
</body>

</html>
