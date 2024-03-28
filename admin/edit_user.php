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

        .profile-photo {
            text-align: center;
            margin-bottom: 20px;
        }

        .profile-photo img {
            width: 150px;
            height: 150px;
            border-radius: 50%;
        }


        table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    th, td {
        border: 1px solid #ddd;
        padding: 12px; /* Increased padding for better readability */
        text-align: left;
    }

    th {
        background-color: #3498db;
        color: #fff;
        text-align: center;
    }

    tr:nth-child(even) {
        background-color: #f2f2f2; /* Alternate row color */
    }

    tr:hover {
        background-color: #e0e0e0; /* Hover effect for rows */
    }

    h3 {
        text-align: center;
    }

    h2 {
        text-align: center;
    }

    .action-buttons {
            display: flex;
            gap: 5px;
        }

        .block-button, .edit-button {
            padding: 8px;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background 0.3s;
            text-align: center;
        }
        
        .edit-button {
            background-color: #c0392b; /* Blue color for delete button */
            margin: auto;
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
            <a href="../admin/dashboard">List User</a>
            <a href="../admin/edit_user.php">Edit User</a>
            <a href="../admin/logout">Keluar</a>
        </div>
        <div class="content">
            <div class="form-container">
                <h2>Edit User</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        // Include the database connection details
                        include '../php/config.php';

                        // Check connection
                        if ($conn->connect_error) {
                            die("Connection failed: " . $conn->connect_error);
                        }

                        // Fetch user data from the database
                        $sql = "SELECT * FROM users";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            // Output data of each row
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . $row["fname"], $row["lname"] . "</td>";
                                echo "<td>" . $row["email"] . "</td>";
                                echo "<td class='action-buttons'>";
                                echo "<a class='edit-button' href='edit_aksi''>Edit</a>";

                                echo "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='4'>No users found</td></tr>";
                        }

                        // Close connection
                        $conn->close();
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</body>

</html>