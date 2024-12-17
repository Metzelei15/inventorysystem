<?php include('dbconn.php')?>
<?php 
	$sql = "SELECT * FROM categorytable";
	try {
		$stmt = $conn->prepare($sql);
		$stmt->execute();
		$result1=$stmt->fetchAll();
	} catch (PDOException $ex) {
		echo($ex->ex.getMessage());
	}

?>
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

		if($result1 > 0) {
			echo "<table>
					<tr><th>CATEGORY ID
					</th><th>NAME
					</th><th>DESCRIPTION
					</th><th>MODIFY
					</th></tr>";
					// output data of each row
					foreach($result1 as $row) {
				    	echo"<tr><td>".$row["INTcategoryid"].
				    		"</td><td>".$row["STRcategoryname"].
				    		"</td><td>".$row["STRcategorydesc"].
				    		"</td><tr>";
					}
			echo "</table>";
		}else{
			echo "0 results";
		}
	?>
</body>
</html>