<?php 
	session_start();
	include('dbconn.php');

	if (isset($_POST['username']) && isset($_POST['password'])) {
		$username = $_POST['username'];
		$password = $_POST['password'];
		
		// Sanitize inputs to prevent SQL injection
		$username = mysqli_real_escape_string($conn, $username);
		$password = mysqli_real_escape_string($conn, $password);
		
		// Query to join `account` and `accountrole` tables
		$query = "
			SELECT a.`INTaccntid`, ar.`STRaccntrole`
			FROM `account` a
			JOIN `account role` ar ON a.`INTaccntid` = ar.`INTaccntid`
			WHERE a.`STRusername` = '$username' AND a.`INTpassword` = '$password'
		";
		$result = mysqli_query($conn, $query);
		
		if (mysqli_num_rows($result) > 0) {
			$row = mysqli_fetch_assoc($result);
			
			$_SESSION["role"] = $row['STRaccntrole'];
			$_SESSION["accntid"] = $row['INTaccntid'];
			
			// Redirect based on role
			if ($row['STRaccntrole'] == 'admin') {
				echo "<script>document.location.href='adminhomepage.php';</script>";
			} else if ($row['STRaccntrole'] == 'staff') {
				echo "<script>document.location.href='staffhomepage.php';</script>";
			}
		}
	}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Mhaine Inventory System</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f4f4f9;
        }
        .login-container {
            background-color: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 300px;
            text-align: center;
        }
        h2 {
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin: 10px 0 5px;
            text-align: left;
        }
        input[type="text"], input[type="password"] {
            width: 90%;
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        button {
            width: 100%;
            padding: 10px;
            background-color: #04AA6D;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
        }
        button:hover {
            background-color: #45a049;
        }
		
        .error-message {
            color: red;
            font-size: 14px;
        }
    </style>
</head>
<body>

<div class="login-container">
    <h2>Mhaine Inventory System</h2>

    <!-- Login Form -->
    <form method="POST">
        <label for="username">Username</label>
        <input type="text" name="username" placeholder="Username" required>

        <label for="password">Password</label>
        <input type="password" name="password" placeholder="Password" required>

        <button type="submit">Login</button>
    </form>

    <!-- Display Error Message if credentials are incorrect -->
    <?php
    if (isset($_POST['username']) && isset($_POST['password']) && mysqli_num_rows($result) === 0) {
        echo "<div class='error-message'>Invalid username or password. Please try again.</div>";
    }
    ?>
</div>

</body>
</html>
