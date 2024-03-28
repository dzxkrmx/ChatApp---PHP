<?php
session_start();
include_once "php/config.php";

if (!isset($_SESSION['unique_id'])) {
    header("location: ../login.php");
    exit();
}

$unique_id = mysqli_real_escape_string($conn, $_SESSION['unique_id']);

$sql = mysqli_query($conn, "SELECT * FROM users WHERE unique_id = {$unique_id}");

if (!$sql) {
    die("Terjadi kesalahan. Silakan coba lagi!");
}

if (mysqli_num_rows($sql) > 0) {
    $row = mysqli_fetch_assoc($sql);
} else {
    echo "Pengguna tidak ditemukan!";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $currentPassword = mysqli_real_escape_string($conn, $_POST['current_password']);
    $newPassword = mysqli_real_escape_string($conn, $_POST['new_password']);
    $confirmPassword = mysqli_real_escape_string($conn, $_POST['confirm_password']);

    if ($currentPassword === $row['password']) {
        if ($newPassword === $confirmPassword) {
            $updateQuery = mysqli_query($conn, "UPDATE users SET password = '$newPassword' WHERE unique_id = {$unique_id}");

            if ($updateQuery) {
                $_SESSION['password_change_success'];
                echo '<script>alert("Password berhasil diubah!"); window.location.href = "users_settings.php";</script>';
                exit();
            } else {
                echo "Terjadi kesalahan. Silakan coba lagi!";
            }
        } else {
            echo "Password baru dan konfirmasi password tidak cocok!";
        }
    } else {
        echo "Password saat ini tidak sesuai!";
    }
}
?>
