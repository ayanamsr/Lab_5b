<?php
// Include database connection
include 'database.php';

// Check if matric number is passed via GET
if (isset($_GET['matric'])) {
    $matric = $_GET['matric'];

    // Prepare and execute delete query
    $stmt = $conn->prepare("DELETE FROM users WHERE matric = ?");
    $stmt->bind_param("s", $matric);

    if ($stmt->execute()) {
        // Redirect back to display.php after successful deletion
        header("Location: display.php?status=success");
        exit();
    } else {
        // Handle deletion error
        echo "<p>Error: Unable to delete the record. Please try again.</p>";
    }

    $stmt->close();
} else {
    echo "<p>Error: No matric number specified.</p>";
}

// Close the database connection
$conn->close();
?>
