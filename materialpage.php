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
		$query = "SELECT * FROM `materialtable`;";
		$result = mysqli_query($conn, $query);

		if($result->num_rows > 0) {
			echo "<table>
					<tr><th>MATERIAL ID
					</th><th>NAME
					</th><th>DESCRIPTION
					</th><th>QUANTITY
					</th></tr>";
					// output data of each row
					while($row = $result->fetch_assoc()) {
				    	echo"<tr><td>".$row["INTmatid"].
				    		"</td><td>".$row["STRmatname"].
				    		"</td><td>".$row["STRmatdesc"].
				    		"</td><td>".$row["INTmatquan"].
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