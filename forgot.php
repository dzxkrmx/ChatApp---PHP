<?php
// Include file untuk koneksi ke database
include 'php/config.php'; // Sesuaikan dengan nama file dan lokasi koneksi database Anda

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Mengambil email dari formulir
    $email = $_POST['email'];

    // Query untuk memeriksa apakah email ada di database
    $query = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($koneksi, $query);

    if ($result) {
        // Memeriksa jumlah baris hasil query
        if (mysqli_num_rows($result) > 0) {
            // Email ditemukan di database, lakukan langkah reset password
            // ... (Tambahkan langkah reset password di sini)

            echo "Email ditemukan di database. Lakukan langkah reset password.";
        } else {
            // Email tidak ditemukan di database
            echo "Email tidak ditemukan. Pastikan email yang dimasukkan benar.";
        }
    } else {
        // Kesalahan dalam menjalankan query
        echo "Kesalahan dalam menjalankan query: " . mysqli_error($koneksi);
    }

    // Tutup koneksi database jika diperlukan
    mysqli_close($koneksi);
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - ChatApp</title>
    <link rel="shortcut icon" href="favicon/favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="style.css">
</head>
<body>
<body>
    <div class="wrapper">
        <section class="form login">
            <header><a href="login"><img class="img-logo" src="php/images/logo.png" width="80"></a></header>
            <form action="reset_password.php" method="POST" enctype="multipart/form-data" autocomplete="off">
                <div class="error-text"></div>
                <div class="field input">
                    <label>Email</label>
                    <input type="text" name="email" placeholder="Masukkan Email" required>
                </div>
                <div class="field button">
                    <input type="submit" name="submit" value="Reset Password">
                </div>
            </form>
            <div class="link">- Pastikan email aktif ketika reset password -</div>
        </section>
    </div>

    <?php include 'footer.php' ?>

    <script src="javascript/pass-show-hide.js"></script>

</body>
</body>
</html>