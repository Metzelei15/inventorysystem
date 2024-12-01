<?php 
	include('dbconn.php');
	session_start();

	if (!isset($_SESSION["role"])){
		echo "<script>document.location.href = 'login.php'</script>";
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Admin Dashboard</title>
<style>
	ul {
		list-style-type: none;
		margin: 0;
		padding: 0;
		width: 10%;
		background-color: #f1f1f1;
		position: fixed;
		height: 100%;
		overflow: auto;
	}

	li a {
		display: block;
		color: #000;
		padding: 8px 16px;
		text-decoration: none;
	}

	li a.active {
	  background-color: #04AA6D;
	  color: white;
	}

	li a:hover:not(.active) {
	  background-color: #555;
	  color: white;
	}

	form input {
		display: block;
		color: #000;
		padding: 8px 16px;
		text-decoration: none;
	}

</style>
</head>
<?php
	if (isset($_POST["logout"])){
		session_unset();
		session_destroy();
		echo "<script>document.location.href = 'login.php';</script>";
	}
?>
<body>
	<ul>
		<li>Dashboard</li>
		<li><a href="#product">Product</a></li>
		<li><a href="#material">Material</a></li>
		<li><a href="#report">Report</a></li>
		<form method="POST"><input type="submit" name="logout" value="Logout">
	</ul>
</body>
</html>