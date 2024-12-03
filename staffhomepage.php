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

	form input, form button {
		margin: 10px 0;
		display: block;
		color: #000;
		padding: 8px 16px;
	}

	#content {
		margin-left: 12%;
		padding: 10px;
	}

	table {
		width: 80%;
		border-collapse: collapse;
		margin: 20px auto;
	}

	table th, table td {
		border: 1px solid #ddd;
		padding: 8px;
		text-align: center;
	}

	table th {
		background-color: #04AA6D;
		color: white;
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
		<li><a href="?section=Product" class="<?= isset($_GET['section']) && $_GET['section'] === 'Product' ? 'active' : '' ?>">Product</a></li>
		<li><a href="?section=Material" class="<?= isset($_GET['section']) && $_GET['section'] === 'Material' ? 'active' : '' ?>">Material</a></li>
		<li><a href="?section=Report" class="<?= isset($_GET['section']) && $_GET['section'] === 'Report' ? 'active' : '' ?>">Report</a></li>
		<form method="POST"><input type="submit" name="logout" value="Logout"></form>
	</ul>
	
	<div id="content">
		<?php
		if (isset($_GET['section'])) {
			switch ($_GET['section']) {
				case 'Product':
					$search = isset($_GET['search']) ? trim($_GET['search']) : '';
					$query = "SELECT `INTprodid`, `STRprodname`, `INTprodquan` FROM `producttable`";

					if ($search !== '') {
						$search = $conn->real_escape_string($search);
						if (is_numeric($search)) {
							$query .= " WHERE `INTprodid` = '$search'";
						} else {
							$query .= " WHERE `STRprodname` LIKE '%$search%'";
						}
					}

					$result = mysqli_query($conn, $query);

					echo "
						<form method='GET' style='text-align: center;'>
							<input type='hidden' name='section' value='Product'>
							<input type='text' id='search' name='search' value='" . htmlspecialchars($search) . "' placeholder='Enter Product ID or Name'>
							<button type='submit'>Search</button>
						</form>";

					echo "<table>
							<tr>
								<th>ID</th>
								<th>Name</th>
								<th>Stock</th>
							</tr>";

					if ($result && $result->num_rows > 0) {
						while ($row = $result->fetch_assoc()) {
							echo "
								<tr>
									<td>" . htmlspecialchars($row['INTprodid']) . "</td>
									<td>" . htmlspecialchars($row['STRprodname']) . "</td>
									<td>" . htmlspecialchars($row['INTprodquan']) . "</td>
								</tr>";
						}
					} else {
						echo "<tr><td colspan='3'>" . ($search !== '' ? "No results found for <strong>" . htmlspecialchars($search) . "</strong>" : "No products found") . "</td></tr>";
					}
					echo "</table>";
					break;

				case 'Material':
					$search = isset($_GET['search']) ? trim($_GET['search']) : '';
					$query = "SELECT `INTmatid`, `STRmatname`, `INTmatquan` FROM `materialtable`";

					if ($search !== '') {
						$search = $conn->real_escape_string($search);
						if (is_numeric($search)) {
							$query .= " WHERE `INTmatid` = '$search'";
						} else {
							$query .= " WHERE `STRmatname` LIKE '%$search%'";
						}
					}

					$result = mysqli_query($conn, $query);

					echo "
						<form method='GET' style='text-align: center;'>
							<input type='hidden' name='section' value='Material'>
							<input type='text' id='search' name='search' value='" . htmlspecialchars($search) . "' placeholder='Enter Material ID or Name'>
							<button type='submit'>Search</button>
						</form>";

					echo "<table>
							<tr>
								<th>ID</th>
								<th>Name</th>
								<th>Stock</th>
							</tr>";

					if ($result && $result->num_rows > 0) {
						while ($row = $result->fetch_assoc()) {
							echo "
								<tr>
									<td>" . htmlspecialchars($row['INTmatid']) . "</td>
									<td>" . htmlspecialchars($row['STRmatname']) . "</td>
									<td>" . htmlspecialchars($row['INTmatquan']) . "</td>
								</tr>";
						}
					} else {
						echo "<tr><td colspan='3'>" . ($search !== '' ? "No results found for <strong>" . htmlspecialchars($search) . "</strong>" : "No materials found") . "</td></tr>";
					}
					echo "</table>";
					break;

				case 'Report':
					echo "<div style='text-align: center;'>
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
