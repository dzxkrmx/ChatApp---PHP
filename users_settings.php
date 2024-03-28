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
    <title>Users Settings - ChatApp</title>
    <link rel="shortcut icon" href="favicon/favicon.png" type="image/x-icon">
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
            height: 500px;
            margin-left: 20px;
            max-width: 800px;
        }

        .profile-info {
            margin-bottom: 20px;
        }

        .profile-info h2 {
            color: #333;
            text-align: center;
            margin-bottom: 50px;
        }

        .profile-info p {
            color: #777;
            margin-bottom: 10px;
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

        form {
            max-width: 400px;
            margin: 0 auto;
            padding: 20px;  
            border-radius: 10px;
        }

        h2 {
            color: #333;
            text-align: center;
            margin-bottom: 20px;
            font-size: 24px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #333;
            font-weight: bold;
        }

        input {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
            transition: border-color 0.3s;
        }

        input:focus {
            border-color: #3498db;
        }

        a {
            display: block;
            color: #3498db;
            text-decoration: none;
            margin-top: 10px;
            font-size: 14px;
        }

        a:hover {
            text-decoration: underline;
        }

        .hidden-password {
            display: inline-block;
            width: 0;
            overflow: hidden;
            white-space: nowrap;
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
            <form action="php/update_profile.php" method="post">
                <h2>Profil Pengguna</h2>
                <br>
                <label for="fname">Nama Depan:</label>
                <input type="text" id="fname" name="fname" value="<?php echo htmlspecialchars($row['fname']); ?>" readonly>

                <label for="lname">Nama Belakang:</label>
                <input type="text" id="lname" name="lname" value="<?php echo htmlspecialchars($row['lname']); ?>" readonly>

                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($row['email']); ?>" readonly>
            </form>

    </div>
</body>

</html>