<?php session_start() ?>
<!DOCTYPE html> 
<html>
<head>
	<title>Mhaine Inventory System</title>
</head>
<body>
<p>Mhaine Inventory System</p>
<?php
	if (isset($_POST["staff"])){
		$_SESSION["role"] = "staff";
	}
	if (isset($_POST["admin"])){
		$_SESSION["role"] = "admin";
	}
	if (isset($_POST["reset"])){
		unset($_SESSION["role"]);
	}
	if (isset($_POST["username"]) && isset($_POST["password"])){
		if ($_POST["username"]=="1234" && $_POST["password"]=="password"){
				echo "<script>document.location.href='staffhomepage.php';</script>";
			} else {
				echo "nuh uh";
		}
	}
?>
<form method="POST">
	<label for="username">Username</label>
	<input type="text" placeholder ="username" name="username" required>

	<label for="password">password</label>
	<input type="text" placeholder ="password" name="password" required>
	
	<button type = "submit">Login</button>
</form>
<form method="POST">
	<label for="staff">Click for Staff</label>
	<input type="submit" name="staff">

	<label for="admin">Click for Admin</label>
	<input type="submit" name="admin">

	<label for="admin">Reset Session Key</label>
	<input type="submit" name="reset">
</form>
<?php
	if (isset($_SESSION["role"])) {
		echo "Role: " . $_SESSION["role"];
	} else {
		echo "Role is not set.";
	}
?>
</body>
</html>