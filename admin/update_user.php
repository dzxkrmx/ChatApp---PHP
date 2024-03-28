<?php

// Include the database connection configuration
include '../php/config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $userId = 1; // Replace with the actual user ID you want to update
    $fname = $_POST["fname"];
    $lname = $_POST["lname"];
    $email = $_POST["email"];
    $password = $_POST["password"]; // Note: This is just a basic example. Consider using password_hash() for better security.

    // Update user information in the database
    $sql = "UPDATE users SET fname='$fname', lname='$lname', email='$email', password='$password' WHERE user_id=$userId";

    if ($conn->query($sql) === TRUE) {
        echo "User information updated successfully.";
    } else {
        echo "Error updating user information: " . $conn->error;
    }
}

// Close connection
$conn->close();

?>
