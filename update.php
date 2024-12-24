<?php
// Include database connection
include 'database.php';

// Initialize variables for messages
$success_message = "";
$error_message = "";

// Check if matric number is passed via GET
if (isset($_GET['matric'])) {
    $matric = $_GET['matric'];

    // Fetch user details from the database
    $stmt = $conn->prepare("SELECT * FROM users WHERE matric = ?");
    $stmt->bind_param("s", $matric);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
    } else {
        $error_message = "User not found.";
    }

    $stmt->close();
} else {
    $error_message = "Error: No matric number specified.";
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $new_matric = $_POST['matric'];
    $name = $_POST['name'];
    $role = $_POST['role'];

    // Update user details in the database
    $stmt = $conn->prepare("UPDATE users SET matric = ?, name = ?, role = ? WHERE matric = ?");
    $stmt->bind_param("ssss", $new_matric, $name, $role, $matric);

    if ($stmt->execute()) {
        $success_message = "User details successfully updated.";
        $matric = $new_matric; // Update matric in case it changes
    } else {
        $error_message = "Error: Unable to update the record. Please try again.";
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update User</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f4f4f4;
        }
        form {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            max-width: 400px;
            margin: auto;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }
        input, select, button {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        button {
            cursor: pointer;
        }
        .btn-cancel {
            background-color: #007bff;
            color: white;
            border: none;
        }
        .btn-submit {
            background-color: #007bff;
            color: white;
            border: none;
        }
        .btn-cancel:hover, .btn-submit:hover {
            opacity: 0.9;
        }
        .message {
            text-align: center;
            margin-bottom: 20px;
        }
        .success {
            color: green;
        }
        .error {
            color: red;
        }
    </style>
</head>
<body>
    <h1>Update User Details</h1>

    <div class="message">
        <?php if ($success_message): ?>
            <p class="success"><?= htmlspecialchars($success_message); ?></p>
        <?php endif; ?>
        <?php if ($error_message): ?>
            <p class="error"><?= htmlspecialchars($error_message); ?></p>
        <?php endif; ?>
    </div>

    <form method="POST" action="">
        <label for="matric">Matric Number</label>
        <input type="text" id="matric" name="matric" value="<?= htmlspecialchars($user['matric'] ?? ''); ?>" required>

        <label for="name">Name</label>
        <input type="text" id="name" name="name" value="<?= htmlspecialchars($user['name'] ?? ''); ?>" required>

        <label for="role">Access Level (Role)</label>
        <select id="role" name="role" required>
            <option value="Lecturer" <?= isset($user['role']) && $user['role'] === 'Lecturer' ? 'selected' : ''; ?>>Lecturer</option>
            <option value="Student" <?= isset($user['role']) && $user['role'] === 'Student' ? 'selected' : ''; ?>>Student</option>
        </select>

        <button type="submit" class="btn-submit">Submit</button>
        <button type="button" class="btn-cancel" onclick="window.location.href='display.php';">Cancel</button>
    </form>
</body>
</html>
