<?php
// Include database connection
include 'database.php';

// Initialize error and success messages
$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $matric = $_POST['matric'];
    $name = $_POST['name'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    // Validate inputs
    if (!empty($matric) && !empty($name) && !empty($password) && !empty($role)) {
        // Check if the matric number already exists
        $stmt = $conn->prepare("SELECT * FROM users WHERE matric = ?");
        $stmt->bind_param("s", $matric);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $error = "Matric number already registered.";
        } else {
            // Insert new user into the database
            $stmt = $conn->prepare("INSERT INTO users (matric, name, password, role) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $matric, $name, $password, $role);

            if ($stmt->execute()) {
                $success = "Registration successful! You can now <a href='login.php'>login</a>.";
            } else {
                $error = "Error: Unable to register. Please try again.";
            }
            $stmt->close();
        }
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
    <title>Register</title>
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
        .register-container {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            width: 300px;
        }
        .register-container h1 {
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
        .form-group input, .form-group select {
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
        .success {
            color: green;
            margin-bottom: 10px;
            text-align: center;
        }
        button {
            margin-bottom: 15px;
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
        .cancel-btn {
            width: 100%;
            padding: 10px;
            background: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .cancel-btn:hover {
            background: #0056b3;
        }
    </style>
</head>
<body>
    <div class="register-container">
        <h1>Register</h1>

        <?php if (!empty($error)) { echo "<div class='error'>$error</div>"; } ?>
        <?php if (!empty($success)) { echo "<div class='success'>$success</div>"; } ?>

        <form method="POST" action="">
            <div class="form-group">
                <label for="matric">Matric Number</label>
                <input type="text" id="matric" name="matric" required>
            </div>
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="form-group">
                <label for="role">Role</label>
                <select id="role" name="role" required>
                    <option value="">-- Select Role --</option>
                    <option value="Lecturer">Lecturer</option>
                    <option value="Student">Student</option>
                </select>
            </div>
            <button type="submit" class="submit-btn">Register</button>
            <button type="button" class="cancel-btn" onclick="window.location.href='login.php';">Cancel</button>
        </form>
    </div>
</body>
</html>
