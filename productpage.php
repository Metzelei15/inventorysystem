<?php include('dbconn.php') ?>
<!DOCTYPE html>
<html>
<head>
	<title>Product</title>
	<style>
		table, th, td {
			border: 1px solid;
		}
	</style>
</head>
<body>
<?php
	$query = "SELECT * FROM `producttable`";
	$stmt = $conn->prepare($query);

	$stmt->execute();

	$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

	if (count($results) > 0) {
		echo "<table>
				<tr>
					<th>PRODUCT ID</th>
					<th>NAME</th>
					<th>DESCRIPTION</th>
					<th>QUANTITY</th>
					<th>CATEGORY</th>
				</tr>";
		
		// Output data of each row
		foreach ($results as $row) {
			echo "<tr>
					<td>" . htmlspecialchars($row["INTprodid"]) . "</td>
					<td>" . htmlspecialchars($row["STRprodname"]) . "</td>
					<td>" . htmlspecialchars($row["STRproddesc"]) . "</td>
					<td>" . htmlspecialchars($row["INTprodquan"]) . "</td>
					<td>" . htmlspecialchars($row["INTcategoryid"]) . "</td>
				</tr>";
		}

		echo "</table>";
	} else {
		echo "0 results";
	}
	$conn = null;
	?>

</body>
</html>