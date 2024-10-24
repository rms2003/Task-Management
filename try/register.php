<?php
session_start();
include 'db.php'; // database coded
include 'functions.php'; // validation file 

$usernameError = $emailError = $passwordError = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $email = trim($_POST['email']);

    // Validate input
    $isValid = true;

    // Validate username
    if (!validate_username($username)) {
        $usernameError = "Invalid username."; //error message
        $isValid = false;
    }

    // Validate email
    if (!validate_email($email)) {
        $emailError = "Invalid email format."; // error message
        $isValid = false;
    }

    // Validate password
    if (!validate_password($password)) {
        $passwordError = "Password must be at least 6 characters long."; // error message for 6 characters
        $isValid = false;
    }

    // if validation is successful
    if ($isValid) {
        // Check if username or email already exists
        $stmt = $connection->prepare("SELECT * FROM users WHERE username = ? OR email = ?");
        $stmt->bind_param("ss", $username, $email);
        $stmt->execute();
        $result = $stmt->get_result();

        // If no existing user, then go to registration page
        if ($result->num_rows === 0) {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $connection->prepare("INSERT INTO users (username, password, email) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $username, $hashed_password, $email);
            
            if ($stmt->execute()) {
                $_SESSION['message'] = "Registration successful. You can now login.";
                header("Location: login.php");
                exit(); 
            } else {
                $_SESSION['error'] = "Registration failed: " . $stmt->error; // Show the error
            }
        } else {
            $_SESSION['error'] = "Username or email already exists."; // for duplicate username or email
        }
    }
}

$connection->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <style>
        body {
            font-family: 'Comic Sans MS', cursive, sans-serif;
            background-color: #ffeb3b;
            margin: 0;
            color: #123456;
            padding: 0;
            font-size: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh; 
        }
        .container {
            display: flex;
            flex-wrap: wrap; 
            height: 70%;
            flex-direction: column;
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
            width: 50%; 
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
            background-color: #f0f0f0;
        }
        .image-column img {
            max-width: 100%;
            max-height: 100%;
            object-fit: cover; /* Ensure the image scales correctly */
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
            font-size: 50px; /* Increased font size */
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
                <h2>Register</h2>
                <div class="form-group">
                    <label for="username">Username:</label>
                    <input type="text" name="username" class="form-control" placeholder="Username" required>
                    <span class="error-message"><?php echo $usernameError; ?></span>
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" name="email" class="form-control" placeholder="Email" required>
                    <span class="error-message"><?php echo $emailError; ?></span>
                </div>
                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" name="password" class="form-control" placeholder="Password" required>
                    <span class="error-message"><?php echo $passwordError; ?></span>
                </div>

                <button type="submit" class="btn">Register</button>
                
                <!-- messages -->
                <?php if (isset($_SESSION['error'])): ?>
                    <div class="error-message"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
                <?php endif; ?>
                <?php if (isset($_SESSION['message'])): ?>
                    <div class="error-message" style="color: green;"><?php echo $_SESSION['message']; unset($_SESSION['message']); ?></div>
                <?php endif; ?>
                
                <button type="button" class="btn" onclick="window.location.href='login.php';">Login</button>
            </form>
        </div>
        <div class="column">
            <img src="image1.png" alt="Decorative Image">
        </div>
    </div>
</body>
</html>
