<?php 
  session_start();
  if(isset($_SESSION['unique_id'])){
    header("location: index.php");
  }
?>

<?php include_once "header.php"; ?>

<body>
    <div class="wrapper">
        <section class="form signup">
            <header><a href="login"><img class="img-logo" src="php/images/logo.png" width="80"></a></header>
            <form action="#" method="POST" enctype="multipart/form-data" autocomplete="off">
                <div class="error-text"></div>
                <div class="name-details">
                    <div class="field input">
                        <label>Nama Awal</label>
                        <input type="text" name="fname" placeholder="Nama Awal" required>
                    </div>
                    <div class="field input">
                        <label>Nama Akhir</label>
                        <input type="text" name="lname" placeholder="Nama Akhir" required>
                    </div>
                </div>
                <div class="field input">
                    <label>Email</label>
                    <input type="text" name="email" placeholder="Masukkan Email" required>
                </div>
                <div class="field input">
                    <label>Password</label>
                    <input type="password" name="password" placeholder="Masukkan Password" required>
                    <i class="fas fa-eye"></i>
                </div>
                <div class="field image">
                    <label>Pilih Foto</label>
                    <input type="file" name="image" accept="image/x-png,image/gif,image/jpeg,image/jpg" required>
                </div>
                <div class="field button">
                    <input type="submit" name="submit" value="Chat Start">
                </div>
            </form>
            <div class="link">Sudah memiliki akun? <a href="login.php">Login Sekarang</a></div>
            <div class="link">- Pesan terencrypt end to end -</div>

        </section>
    </div>

  <?php include 'footer.php' ?>

    <script src="javascript/pass-show-hide.js"></script>
    <script src="javascript/signup.js"></script>

</body>

</html>