<?php 
    session_start();
    include_once "config.php";
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    if (!empty($email) && !empty($password)) {
        $sql = mysqli_query($conn, "SELECT * FROM users WHERE email = '{$email}'");
        if (mysqli_num_rows($sql) > 0) {
            $row = mysqli_fetch_assoc($sql);
            $enc_pass = $row['password'];
            if ($password === $enc_pass) {  // Fix: Corrected variable name here
                $status = "Online";
                $sql2 = mysqli_query($conn, "UPDATE users SET status = '{$status}' WHERE unique_id = {$row['unique_id']}");
                if ($sql2) {
                    $_SESSION['unique_id'] = $row['unique_id'];
                    echo "success";
                } else {
                    echo "Ada yang salah. Silakan coba lagi!";
                }
            } else {
                echo "Email atau kata sandi salah!";
            }
        } else {
            echo "$email - Email ini tidak ada!";
        }
    } else {
        echo "Semua kolom input wajib diisi!";
    }
?>
