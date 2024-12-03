<?php 
	include('dbconn.php');
	session_start();

	if (!isset($_SESSION["role"])){
		echo "<script>document.location.href = 'login.php'</script>";
	} else if ($_SESSION["role"]=="admin"){
		echo "<script>document.location.href = 'adminhomepage.php'</script>";
	}

	if (isset($_GET['section'])) {
		echo "You have clicked on the " . $_GET['section'] . " section.";
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Staff Dashboard</title>
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

	#content {
		place-items: center;
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
		<li><a href="?section=Product">Product</a></li>
		<li><a href="?section=Material">Material</a></li>
		<li><a href="?section=Report">Report</a></li>
		<form method="POST"><input type="submit" name="logout" value="Logout">
	</ul>
	
	<div id="content">
		<?php
		if (isset($_GET['section'])) {
			switch ($_GET['section']) {
				case 'Product':
					$query = "SELECT `INTprodid`, `STRprodname`, `INTprodquan` FROM `producttable`;";
    				$result = mysqli_query($conn, $query);
					echo "
						<table>
							<tr>
								<th>ID</th>
								<th>Name</th>
								<th>Stock</th>
							</tr>";
					if ($result->num_rows > 0) {
						while ($row = $result->fetch_assoc()) {
							echo "
								<tr>
									<td>" . $row['INTprodid'] . "</td>
									<td>" . $row['STRprodname'] . "</td>
									<td>" . $row['INTprodquan'] . "</td>
								</tr>";
						}
					} else {
						echo "
							<tr>
								<td colspan='3'>No products found</td>
							</tr>";
					}
					echo "</table>";
					break;
				case 'Material':
					$query = "SELECT `INTmatid`, `STRmatname`, `INTmatquan` FROM `materialtable`;";
    				$result = mysqli_query($conn, $query);
					echo "
						<table>
							<tr>
								<th>ID</th>
								<th>Name</th>
								<th>Stock</th>
							</tr>";
					if ($result->num_rows > 0) {
						while ($row = $result->fetch_assoc()) {
							echo "
								<tr>
									<td>" . $row['INTmatid'] . "</td>
									<td>" . $row['STRmatname'] . "</td>
									<td>" . $row['INTmatquan'] . "</td>
								</tr>";
						}
					} else {
						echo "
							<tr>
								<td colspan='3'>No products found</td>
							</tr>";
					}
					echo "</table>";
					break;
				case 'Report':
					echo "You are viewing the Report section.";
					echo "
					<div style='text-align: center;'>
						<button onClick=alert('WalapangReport')>Generate Report</button>
					</div>";
					break;
				default:
					echo "Please select a section.";
			}
		}
		?>
	</div>
</body>
</html>