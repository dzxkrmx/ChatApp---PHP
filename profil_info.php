<div class="profile-info">
                <h2>Profil Pengguna</h2>
                <p><strong>User ID :</strong> <?php echo htmlspecialchars($row['user_id']); ?></p>
                <p><strong>Nama :</strong> <?php echo htmlspecialchars($row['fname'] . ' ' . $row['lname']); ?></p>
                <p><strong>Email :</strong> <?php echo htmlspecialchars($row['email']); ?></p>
                <p><strong>Password :</strong> <span class="hidden-password"><?php echo htmlspecialchars($row['password']); ?></span> &#8226;&#8226;&#8226;&#8226;&#8226;</p>
            </div>
        </div>