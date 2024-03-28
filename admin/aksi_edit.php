<?php
include '../php/config.php';

// Logika PHP untuk memproses formulir edit user
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data yang dikirimkan melalui formulir
    $unique_id = $_POST["unique_id"];
    $fname = $_POST["fname"];
    $lname = $_POST["lname"];
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Validasi dan pemrosesan data (sesuai kebutuhan)

    // Update data pengguna
    $sql = "UPDATE users SET fname='$fname', lname='$lname', email='$email', password='$password' WHERE unique_id='$unique_id'";

    if ($conn->query($sql) === TRUE) {
        echo "User updated successfully";
    } else {
        echo "Error updating user: " . $conn->error;
    }
}
?>
