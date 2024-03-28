<?php
session_start();
include_once "php/config.php";

// Redirect to login page if the user or admin is not logged in
if (!isset($_SESSION['unique_id']) && !isset($_SESSION['admin_id'])) {
    header("location: login");
    exit();
}

// Fetch user details if logged in as a user
if (isset($_SESSION['unique_id'])) {
    $sql = mysqli_query($conn, "SELECT * FROM users WHERE unique_id = {$_SESSION['unique_id']}");
    if (mysqli_num_rows($sql) > 0) {
        $row = mysqli_fetch_assoc($sql);
    }
}

// Fetch admin details if logged in as an admin
if (isset($_SESSION['admin_id'])) {
    $sql_admin = mysqli_query($conn, "SELECT * FROM admin WHERE id = {$_SESSION['admin_id']}");
    if (mysqli_num_rows($sql_admin) > 0) {
        $row_admin = mysqli_fetch_assoc($sql_admin);
    }
}

include_once "header.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Chakra+Petch:wght@700&display=swap" rel="stylesheet">
</head>

<body>
    <div class="awak">
        <section class="users">
            <header>
                <div class="content">
                    <?php if (isset($row)) : ?>
                        <!-- Display user details -->
                        <img src="php/images/<?php echo $row['img']; ?>" alt="">
                        <div class="details">
                            <span><?php echo $row['fname'] . " " . $row['lname'] ?></span>
                            <p><?php echo $row['status']; ?></p>
                        </div>
                    <?php elseif (isset($row_admin)) : ?>
                        <!-- Display admin details -->
                        <img src="php/images/<?php echo $row_admin['img']; ?>" alt="">
                        <div class="details">
                            <span><?php echo $row_admin['username']; ?></span>
                            <p>Admin</p>
                        </div>
                    <?php endif; ?>
                </div>
                <a href="./users_settings" class="settings-btn"><i class="fas fa-cog"></i></a>
                <a href="php/logout" class="logout">Keluar</a>
            </header>
            <div class="search">
                <span class="text">Cari sesuatu di sini</span>
                <input type="text" placeholder="Masukkan nama untuk mencari...">
                <button><i class="fas fa-search"></i></button>
            </div>
            <div class="users-list">
                <!-- Users list goes here -->
            </div>
        </section>
    </div>

    <?php include 'footer.php' ?>

    <script src="javascript/users.js"></script>

</body>

</html>
