<?php include('dbconn.php') ?>
<?php 
	$query = "SELECT * FROM producttable";
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
	<title>Product</title>
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
					<tr><th>PRODUCT ID
					</th><th>NAME
					</th><th>DESCRIPTION
					</th><th>QUANTITY
					</th><th>CATEGORY
					</th><th>MODIFY
					</th></tr>";
					// output data of each row
					foreach($result as $row) {
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
	?>
</body>
</html>