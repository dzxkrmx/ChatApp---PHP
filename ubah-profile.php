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
$sql = mysqli_query($conn, "SELECT * FROM users WHERE unique_id = '$unique_id'");

if (!$sql) {
    die("Terjadi kesalahan saat mengambil data pengguna. Silakan coba lagi!");
}

if (mysqli_num_rows($sql) > 0) {
    $row = mysqli_fetch_assoc($sql);

    // Susun URL gambar dengan benar
    $imgUrl = "php/images/" . htmlspecialchars($row['img']);
} else {
    die("Pengguna tidak ditemukan!");
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    // Process changing profile picture
    if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] !== 4) { // Check if file input is not empty
        // Validasi dan update gambar profil
        $imgName = $_FILES['profile_picture']['name'];
        $imgTmp = $_FILES['profile_picture']['tmp_name'];
        $imgSize = $_FILES['profile_picture']['size'];
        $imgError = $_FILES['profile_picture']['error'];

        // Validasi tipe file
        $allowedExtensions = array("jpg", "jpeg", "png");
        $imgExtension = strtolower(pathinfo($imgName, PATHINFO_EXTENSION));

        if (!in_array($imgExtension, $allowedExtensions)) {
            die("Hanya file gambar dengan ekstensi JPG, JPEG, dan PNG yang diizinkan.");
        }

        // Validasi ukuran file (misalnya, maksimal 1 MB)
        $maxFileSize = 1 * 1024 * 1024; // 1 MB

        if ($imgSize > $maxFileSize) {
            die("Ukuran file terlalu besar. Maksimal 1 MB.");
        }

        // Pindahkan gambar yang diunggah ke folder tujuan
        $imgPath = "php/images/" . $imgName;
        if (!move_uploaded_file($imgTmp, $imgPath)) {
            die("Gagal mengunggah gambar. Silakan coba lagi!");
        }

        // Update gambar profil pengguna di database
        $updateImgQuery = "UPDATE users SET img = ? WHERE unique_id = ?";
        $stmtImg = mysqli_prepare($conn, $updateImgQuery);

        if ($stmtImg) {
            mysqli_stmt_bind_param($stmtImg, "ss", $imgName, $unique_id);

            if (!mysqli_stmt_execute($stmtImg)) {
                die("Terjadi kesalahan saat mengganti foto profil. Silakan coba lagi!");
            }

            mysqli_stmt_close($stmtImg);
        } else {
            die("Terjadi kesalahan saat menyiapkan statement. Silakan coba lagi!");
        }
    }

    // Process changing username
    if (!empty($_POST['fname']) || !empty($_POST['lname'])) {
        // Validasi dan update nama pengguna
        $newFirstName = mysqli_real_escape_string($conn, $_POST['fname']);
        $newLastName = mysqli_real_escape_string($conn, $_POST['lname']);
        $updateNameQuery = "UPDATE users SET fname = ?, lname = ? WHERE unique_id = ?";
        $stmtName = mysqli_prepare($conn, $updateNameQuery);

        if ($stmtName) {
            mysqli_stmt_bind_param($stmtName, "sss", $newFirstName, $newLastName, $unique_id);

            if (!mysqli_stmt_execute($stmtName)) {
                die("Terjadi kesalahan saat mengganti nama pengguna. Silakan coba lagi!");
            }

            mysqli_stmt_close($stmtName);
        } else {
            die("Terjadi kesalahan saat menyiapkan statement. Silakan coba lagi!");
        }
    }

    header("Location: ubah-profile.php");
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
            background-color: #f2f2f2;
            height: 500px;
            width: 800px;
            margin: auto;
        }

        .form-container h2 {
            color: #333;
            text-align: center;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }

        .input-file,
        .input-text {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        .submit-button {
            background-color: #3498db;
            color: #fff;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            width: 100%;
        }

        .submit-button:hover {
            background-color: #1c4d6e;
        }

        .form-name {
            width: 500px;
            height: 40px;
            border-radius: 10px;
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
        <div class="form-container">
            <h2>Ubah Profil</h2>
            <form action="#" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="profile_picture">Ganti Foto Profil</label>
                    <input type="file" name="profile_picture" accept="image/*" class="input-file">
                </div>

                <div class="form-group">
                    <label for="fname">Ganti Nama Depan</label>
                    <input type="text" name="fname" placeholder="Masukkan Nama Depan" class="form-name">
                    <br>
                    <br>
                    <label for="lname">Ganti Nama Belakang</label>
                    <input type="text" name="lname" placeholder="Masukkan Nama Belakang" class="form-name">
                </div>
                <br>
                <div class="form-group">
                    <button type="submit" name="submit" class="submit-button">Simpan Perubahan</button>
                </div>
            </form>
        </div>
</body>

</html>