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
</head>
<body>
	<ul>
		<li>Dashboard</li>
		<li><a href="#product">Product</a></li>
		<li><a href="#material">Material</a></li>
		<li><a href="#report">Report</a></li>
	</ul>
</body>
</html>