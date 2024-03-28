<?php
include '../php/config.php';

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['unique_id']) && is_numeric($_GET['unique_id'])) {
    $user_id = $_GET['unique_id'];

    $delete_query = "DELETE FROM users WHERE unique_id = $user_id";
    if ($conn->query($delete_query) === TRUE) {
        header("Location: ../admin/dashboard.php");
        exit();
    } else {
        echo "Error deleting user: " . $conn->error;
    }
} else {
    echo "Invalid user ID";
}

$conn->close();
?>
