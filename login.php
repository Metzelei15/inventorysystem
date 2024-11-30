<?php session_start() ?>
<!DOCTYPE html> 
<html>
<head>
	<title>Mhaine Inventory System</title>
</head>
<body>
<p>Mhaine Inventory System</p>
<?php
	if (isset($_POST["username"]) && isset($_POST["password"])){
	 $_SESSION["isuser"] = true;
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
</body>
</html>