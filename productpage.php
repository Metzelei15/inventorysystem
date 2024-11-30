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
		$query = "SELECT * FROM `producttable`;";
		$result = mysqli_query($conn, $query);

		if($result->num_rows > 0) {
			echo "<table>
					<tr><th>PRODUCT ID
					</th><th>NAME
					</th><th>DESCRIPTION
					</th><th>QUANTITY
					</th><th>CATEGORY
					</th></tr>";
					// output data of each row
					while($row = $result->fetch_assoc()) {
				    	echo"<tr><td>".$row["INTprodid"].
				    		"</td><td>".$row["STRprodname"].
				    		"</td><td>".$row["STRproddesc"].
				    		"</td><td>".$row["INTprodquan"].
				    		"</td><td>".$row["INTcategoryid"].
				    		"</td><tr>";
					}
			echo "</table>";
		}else{
			echo "0 results";
		}
		$conn->close();
	?>
</body>
</html>