<?php
session_start();

if (isset($_SESSION['unique_id'])) {
    include_once "config.php";

    $status = "Offline";
    $user_id = $_SESSION['unique_id'];

    $sql = mysqli_query($conn, "UPDATE users SET status = '{$status}' WHERE unique_id = {$user_id}");

    if ($sql) {
        session_unset();
        session_destroy();
        header("location: ../login.php");
        exit();
    } else {
        echo "Logout failed. SQL error: " . mysqli_error($conn);
        exit();
    }
} else {
    header("location: ../login.php");
    exit();
}
?>
