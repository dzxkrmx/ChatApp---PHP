<?php
session_start();
include_once "php/config.php";

// Pastikan pengguna sudah login sebelum mengakses halaman pengaturan
if (!isset($_SESSION['unique_id'])) {
    header("location: ../login.php"); // Ganti dengan halaman login Anda
    exit();
}

$unique_id = mysqli_real_escape_string($conn, $_SESSION['unique_id']);

// Ambil data pengguna dari database
$sql = mysqli_query($conn, "SELECT * FROM users WHERE unique_id = {$unique_id}");

if (!$sql) {
    die("Terjadi kesalahan. Silakan coba lagi!");
}

if (mysqli_num_rows($sql) > 0) {
    $row = mysqli_fetch_assoc($sql);

    // Susun URL gambar dengan benar
    $imgUrl = "php/images/" . htmlspecialchars($row['img']);
} else {
    echo "Pengguna tidak ditemukan!";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengaturan Pengguna</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Chakra Petch', sans-serif;
        }

        body {
            display: flex;
            min-height: 100vh;
            background: #C0C0C0;
            padding: 0;
            margin: 0;
            justify-content: center;
            align-items: center;
        }

        .container {
            display: flex;
            max-width: 1100px;
            width: 100%;
            margin: 0 auto;
        }

        .sidebar {
            background: #3498db;
            color: #fff;
            width: 250px;
            height: 500px;
            padding: 20px;
            border-radius: 20px;
        }

        .sidebar a {
            display: block;
            padding: 10px;
            margin-bottom: 10px;
            color: #fff;
            text-decoration: none;
            background: #2980b9;
            border-radius: 5px;
            transition: background 0.3s;
            text-align: center;
        }

        .sidebar a:hover {
            background: #1c4d6e;
        }

        .content {
            background-color: #fff;
            flex: 1;
            padding: 30px;
            color: #333;
            border-radius: 20px;
            margin-left: 20px;
            max-width: 800px;
        }

        .profile-photo {
            text-align: center;
            margin-bottom: 20px;
        }

        .profile-photo img {
            width: 150px;
            height: 150px;
            border-radius: 50%;
        }

        .form-container {
            margin-top: 20px;
            padding: 20px;
            border-radius: 10px;
        }

        .form-container h2 {
            color: #333;
            text-align: center;
            margin-bottom: 20px;
        }

        .form-container label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }

        .form-container input {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        .form-container button {
            background-color: #3498db;
            color: #fff;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        .form-container button:hover {
            background-color: #1c4d6e;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="sidebar">
            <div class="profile-photo">
                <img src="<?php echo $imgUrl; ?>" alt="Profile Photo">
            </div>
            <a href="index.php">Kembali ke Chat</a>
            <br>
            <a href="ubah-profile.php">Ubah Profil</a>
            <a href="ubah-pw.php" onclick="toggleChangePasswordForm()">Ubah Password</a>
        </div>
        <div class="content">
            <div class="form-container">
                <!-- Notifikasi -->
                <?php
                if (isset($_SESSION['password_change_success'])) {
                    echo '<div class="notification success">' . $_SESSION['password_change_success'] . '</div>';
                    unset($_SESSION['password_change_success']); // Hapus sesi notifikasi setelah ditampilkan
                }
                ?>
                <h2>Ubah Password</h2>
                <form action="change_password.php" method="post" onsubmit="return validatePasswordForm()">
                    <label for="current_password">Password Saat Ini:</label>
                    <input type="password" name="current_password" required>

                    <label for="new_password">Password Baru:</label>
                    <input type="password" name="new_password" id="new_password" required>

                    <label for="confirm_password">Konfirmasi Password Baru:</label>
                    <input type="password" name="confirm_password" id="confirm_password" required>

                    <button type="submit">Simpan Perubahan</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        function validatePasswordForm() {
            var newPassword = document.getElementById('new_password').value;
            var confirmPassword = document.getElementById('confirm_password').value;

            if (newPassword !== confirmPassword) {
                alert("Password baru dan konfirmasi password tidak cocok!");
                return false;
            }

            return true;
        }
    </script>

</body>

</html>