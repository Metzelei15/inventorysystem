<?php include('dbconn.php')?>
<!DOCTYPE html>
<html>
<head>
	<title>Category</title>
	<style>
		table, th, td {
			border: 1px solid;
		}
	</style>
</head>
<body>
	<?php
		$query = "SELECT * FROM `categorytable`;";
		$result = mysqli_query($conn, $query);

		if($result->num_rows > 0) {
			echo "<table>
					<tr><th>CATEGORY ID
					</th><th>NAME
					</th><th>DESCRIPTION
					</th></tr>";
					// output data of each row
					while($row = $result->fetch_assoc()) {
				    	echo"<tr><td>".$row["INTcategoryid"].
				    		"</td><td>".$row["STRcategoryname"].
				    		"</td><td>".$row["STRcategorydesc"].
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