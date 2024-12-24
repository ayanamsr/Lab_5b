<?php
// Include database connection
include 'database.php';

// Fetch all users from the database
$query = "SELECT * FROM users";
$result = $conn->query($query);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Display Users</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f4f4f4;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #007bff;
            color: white;
        }
        .btn-logout {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 4px;
            text-decoration: none;
            cursor: pointer;
        }
        .btn-logout:hover {
            opacity: 0.9;
        }
    </style>
</head>
<body>
    <h1>List of Users</h1>

    <table>
        <thead>
            <tr>
                <th>Matric</th>
                <th>Name</th>
                <th>Access Level</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['matric']); ?></td>
                        <td><?= htmlspecialchars($row['name']); ?></td>
                        <td><?= $row['role'] === 'Lecturer' ? 'Lecturer' : 'Student'; ?></td>
                        <td>
                            <a href="update.php?matric=<?= htmlspecialchars($row['matric']); ?>">Update</a>
                            |
                            <a href="delete.php?matric=<?= htmlspecialchars($row['matric']); ?>">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4">No users found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <a href="logout.php" class="btn-logout">Logout</a>
</body>
</html>

<?php
$conn->close();
?>
