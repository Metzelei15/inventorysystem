<?php include('dbconn.php')?>
<?php 
	$query = "SELECT * FROM materialtable";
	try {
		$stmt = $conn->prepare($query);
		$stmt->execute();
		$result=$stmt->fetchAll();
	} catch (PDOException $ex) {
		echo($ex->ex.getMessage());
	}

?>
<!DOCTYPE html>
<html>
<head>
	<title>Material</title>
	<style>
		table, th, td {
			border: 1px solid;
		}
	</style>
</head>
<body>
	<?php
		if($result > 0) {
			echo "<table>
					<tr><th>MATERIAL ID
					</th><th>NAME
					</th><th>DESCRIPTION
					</th><th>QUANTITY
					</th><th>MODIFY
					</th></tr>";
					// output data of each row
					foreach($result as $row) {
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
	?>
</body>
</html>