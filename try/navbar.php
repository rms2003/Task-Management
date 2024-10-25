<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <style>
        .navbar {
            display: flex; 
            justify-content: space-between; 
            align-items: center; 
            padding: 10px; 
            background-color: #1974D2; 
            color: white; 
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); 
            height: 60px; 
        }

        .navbar a {
            color: white; 
            text-decoration: none; 
            padding: 8px 16px; 
            font-size: 16px; 
        }

        .navbar a:hover {
            background-color: #0056b3; 
            border-radius: 4px; 
        }

        .navbar-brand {
            color: white !important;
            font-size: 1rem;
            font-weight: bold;
            letter-spacing: 1px;
        }

        .navbar-nav .nav-link {
            color: #f1f1f1 !important;
            font-size: 1.5rem;
            margin-left: 1rem;
        }

        .navbar-nav .nav-link:hover {
            color: #FFD700 !important;
        }

        .navbar-toggler {
            border-color: white;
        }

        .navbar-toggler-icon {
            background-color: white;
        }

        .form-inline {
            display: flex;
            align-items: center;
        }

        .form-inline .form-control {
            border: none;
            border-radius: 20px;
            padding: 0.5rem 1rem;
            background-color: #e9ecef;
            color: #333;
            flex: 1; /* Makes input stretch and fit within the available space */
        }

        .btn-outline-success {
            border-color: #FFD700;
            color: white;
            background-color: #FFD700;
            transition: background-color 0.3s, border-color 0.3s;
            margin-left: 0.5rem; /* Adds space between input and button */
        }

        .btn-outline-success:hover {
            background-color: #333;
            color: white;
            border-color: #333;
        }

        .navbar-nav .nav-item:hover {
            transform: scale(1.1);
            transition: all 0.3s ease-in-out;
        }

        body {
            padding-top: 70px;
        }
    </style>

    <title>Enhanced Navbar</title>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light fixed-top">
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="register.php">Register <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="login.php">Login</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php">Logout</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="dashboard.php">Dashboard</a>
                </li>
            </ul>

            
        </div>
    </nav>

    <!-- Optional JavaScript -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>
