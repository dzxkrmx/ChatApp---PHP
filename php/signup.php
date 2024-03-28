<?php
session_start();
include_once "config.php";

function getRealIpAddr() {
    if (!empty($_SERVER['HTTP_CLIENT_IP']))
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    else
        $ip = $_SERVER['REMOTE_ADDR'];
    return $ip;
}

$user_ip = getRealIpAddr();

$fname = mysqli_real_escape_string($conn, $_POST['fname']);
$lname = mysqli_real_escape_string($conn, $_POST['lname']);
$email = mysqli_real_escape_string($conn, $_POST['email']);
$password = mysqli_real_escape_string($conn, $_POST['password']);

if (!empty($fname) && !empty($lname) && !empty($email) && !empty($password)) {
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $sql = mysqli_query($conn, "SELECT * FROM users WHERE email = '{$email}'");
        if (mysqli_num_rows($sql) > 0) {
            echo "$email - Email ini sudah ada!";
        } else {
            if (isset($_FILES['image'])) {
                $img_name = $_FILES['image']['name'];
                $img_type = $_FILES['image']['type'];
                $tmp_name = $_FILES['image']['tmp_name'];

                $img_explode = explode('.', $img_name);
                $img_ext = end($img_explode);

                $extensions = ["jpeg", "png", "jpg"];
                if (in_array($img_ext, $extensions) === true) {
                    $types = ["image/jpeg", "image/jpg", "image/png"];
                    if (in_array($img_type, $types) === true) {
                        $time = time();
                        $new_img_name = $time . $img_name;
                        if (move_uploaded_file($tmp_name, "images/" . $new_img_name)) {
                            $ran_id = rand(time(), 100000000);
                            $status = "Online";

                            $insert_query = mysqli_query($conn, "INSERT INTO users (unique_id, fname, lname, email, password, img, status)
                                VALUES ({$ran_id}, '{$fname}','{$lname}', '{$email}', '{$password}', '{$new_img_name}', '{$status}')");

                            if ($insert_query) {
                                $timestamp = date("Y-m-d H:i:s");
                                $insert_log_ip = mysqli_query($conn, "INSERT INTO log_ip (email, ip_address, timestamp) VALUES ('{$email}', '{$user_ip}', '{$timestamp}')");

                                if ($insert_log_ip) {
                                    $select_sql2 = mysqli_query($conn, "SELECT * FROM users WHERE email = '{$email}'");
                                    if (mysqli_num_rows($select_sql2) > 0) {
                                        $result = mysqli_fetch_assoc($select_sql2);
                                        $_SESSION['unique_id'] = $result['unique_id'];
                                        echo "success";
                                    } else {
                                        echo "Alamat email ini tidak ada!";
                                    }
                                } else {
                                    echo "Ada yang salah saat menambahkan log IP. Silakan coba lagi!";
                                }
                            } else {
                                echo "Ada yang salah. Silakan coba lagi!";
                            }
                        }
                    } else {
                        echo "Silakan unggah file gambar - jpeg, png, jpg";
                    }
                } else {
                    echo "Silakan unggah file gambar - jpeg, png, jpg";
                }
            }
        }
    } else {
        echo "$email bukan email yang valid!";
    }
} else {
    echo "Semua kolom masukan wajib diisi!";
}
?>
