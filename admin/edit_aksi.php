<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="shortcut icon" href="../favicon/favicon.png" type="image/x-icon">
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

        .form-container {
            text-align: center;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            margin-top: 10px;
            font-weight: bold;
            text-align: left;
            /* Align label text to the left */
        }

        input {
            padding: 8px;
            margin-top: 5px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        button {
            padding: 10px;
            color: #fff;
            background-color: #3498db;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background 0.3s;
        }

        button:hover {
            background-color: #1c4d6e;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="sidebar">
            <div class="profile-photo">
                <h3>Hi, Admin!</h3>
            </div>
            <br>
            <a href="../admin/dashboard">Kembali</a>
        </div>
        <div class="content">
            <div class="form-container">
                <h2>Edit User</h2>
                <?php
                // Include the database connection configuration
                include '../php/config.php';

                // Check if user_id parameter exists in the URL
// Check if user_id parameter exists in the URL
if (isset($_GET['user_id'])) {
    $editUserId = $_GET['user_id'];

    // Fetch user details for the specified user_id
    $sql = "SELECT * FROM users WHERE user_id = $editUserId";
    $result = $conn->query($sql);

    if ($result === FALSE) {
        echo "Error: " . $conn->error;
    } elseif ($result->num_rows > 0) {
        // Display the form for editing
        $row = $result->fetch_assoc();
        ?>
        <form action="update_user.php" method="post">
            <label for="fname">First Name</label>
            <input type="text" name="fname" value="<?php echo $row['fname']; ?>">
            <label for="lname">Last Name</label>
            <input type="text" name="lname" value="<?php echo $row['lname']; ?>">
            <label for="email">Email</label>
            <input type="email" name="email" value="<?php echo $row['email']; ?>">
            <label for="password">Password</label>
            <input type="password" name="password" value="<?php echo $row['password']; ?>">
            <!-- Add a hidden input for user_id -->
            <input type="hidden" name="user_id" value="<?php echo $row['user_id']; ?>">
            <button type="submit" href="update_user_page.php?user_id=1">Update</button>
        </form>
        <?php
    } else {
        echo "No user found with the specified ID.";
    }
} else {
    echo "No user ID specified. URL parameters: " . print_r($_GET, true);
}


                // Close connection
                $conn->close();
                ?>  



            </div>
        </div>
    </div>
</body>

</html>