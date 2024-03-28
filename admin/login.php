<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin Panel - ChatApp</title>
    <link rel="apple-touch-icon" sizes="180x180" href="favicon/favicon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="../favicon/favicon.png">
    <link rel="icon" type="image/png" sizes="16x16" href="../favicon/favicon.png">
    <link rel="manifest" href="/site.webmanifest">
    <link rel="mask-icon" href="/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">

    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" />
</head>

<body>
    <?php 
        session_start();
        // Jika sudah login, redirect ke halaman admin
        if(isset($_SESSION['username'])){
            header("location: admin/dashboard");
        }

        // Sertakan file konfigurasi koneksi
        include '../php/config.php';

        // Logika login
        if(isset($_POST['submit'])){
            $username = $_POST['username'];
            $password = $_POST['password'];

            // Query untuk mendapatkan data admin dari database
            $query = "SELECT * FROM admin WHERE username='$username' AND password='$password'";
            $result = $conn->query($query);

            if($result->num_rows > 0){
                // Jika data admin ditemukan, set session dan redirect ke halaman admin
                $_SESSION['username'] = $username;
                header("location: ../admin/dashboard");
            } else {
                // Jika data admin tidak ditemukan, tampilkan pesan error
                echo "Username atau password salah.";
            }
        }

        // Tutup koneksi setelah selesai
        $conn->close();
    ?>

    <div class="wrapper">
        <section class="form login">
            <header>
                <h4>ADMIN AUTHENTICATOR</h4>
            </header>
            <form method="POST" enctype="multipart/form-data" autocomplete="off">
                <div class="field input">
                    <label>Username</label>
                    <input type="text" name="username" placeholder="Masukkan Username" required>
                </div>
                <div class="field input">
                    <label>Password</label>
                    <input type="password" name="password" placeholder="Masukkan Password" required>
                    <i class="fas fa-eye"></i>
                </div>
                <div class="field button">
                    <input type="submit" name="submit" value="Login">
                </div>
            </form>
        </section>
    </div>

    <?php include '../footer.php' ?>
</body>

</html>
