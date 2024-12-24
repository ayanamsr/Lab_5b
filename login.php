<?php
// Start session
session_start();

// Include database connection
include 'database.php';

// Initialize error message
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $matric = $_POST['matric'];
    $password = $_POST['password'];

    // Validate inputs
    if (!empty($matric) && !empty($password)) {
        // Prepare SQL query
        $stmt = $conn->prepare("SELECT * FROM users WHERE matric = ? AND password = ?");
        $stmt->bind_param("ss", $matric, $password);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Success: Redirect to display.php
            $_SESSION['user'] = $matric;
            header("Location: display.php");
            exit();
        } else {
            $error = "Invalid Matric Number or Password.";
        }

        $stmt->close();
    } else {
        $error = "Please fill in all fields.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f4f4f4;
        }
        .login-container {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            width: 300px;
        }
        .login-container h1 {
            margin-bottom: 20px;
            font-size: 24px;
            text-align: center;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
        }
        .form-group input {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .error {
            color: red;
            margin-bottom: 10px;
            text-align: center;
        }
        .submit-btn {
            width: 100%;
            padding: 10px;
            background: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .submit-btn:hover {
            background: #0056b3;
        }
        .register-link {
            display: block;
            margin-top: 10px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h1>Login</h1>

        <?php if (!empty($error)) { echo "<div class='error'>$error</div>"; } ?>

        <form method="POST" action="">
            <div class="form-group">
                <label for="matric">Matric Number</label>
                <input type="text" id="matric" name="matric" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit" class="submit-btn">Login</button>
        </form>

        <p><a href="register.php">Register here</a> if you have not.</p>
    </div>
</body>
</html>
