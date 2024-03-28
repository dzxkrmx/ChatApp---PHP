<?php 
  session_start();
  if(isset($_SESSION['unique_id'])){
    header("location: index");
  }
?>

<?php include_once "header.php"; ?>

<body>
    <div class="wrapper">
        <section class="form login">
            <header><a href="login"><img class="img-logo" src="php/images/logo.png" width="80"></a></header>
            <form action="#" method="POST" enctype="multipart/form-data" autocomplete="off">
                <div class="error-text"></div>
                <div class="field input">
                    <label>Email</label>
                    <input type="text" name="email" placeholder="Masukkan Email" required>
                </div>
                <div class="field input">
                    <label>Password</label>
                    <input type="password" name="password" placeholder="Masukkan Password" required>
                    <i class="fas fa-eye"></i>
                </div>
                <div class="field input">
                    <a href="forgot" style="color: black;">Lupa Password?</a>
                </div>
                <div class="field button">
                    <input type="submit" name="submit" value="Start Chat">
                </div>
            </form>
            <div class="link">Belum memiliki Akun? <a href="signup" style="color: white;">Daftar Sekarang</a></div>
            <div class="link">- Pesan terencrypt end to end -</div>
        </section>
    </div>

    <?php include 'footer.php' ?>

    <script src="javascript/pass-show-hide.js"></script>
    <script src="javascript/login.js"></script>

</body>

</html>