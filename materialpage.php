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
					</th><th>EDIT
					</th><th>DELETE
					</th></tr>";
					// output data of each row
					foreach($result as $row) {?>
						<tr>
				    		<td><?php echo htmlspecialchars($row["INTmatid"]); ?></td>
		                    <td><?php echo htmlspecialchars($row["STRmatname"]); ?></td>
		                    <td><?php echo htmlspecialchars($row["STRmatdesc"]); ?></td>
		                    <td><?php echo htmlspecialchars($row["INTmatquan"]); ?></td>
				    		<td> <a href="../inventorysystem/material_item_edit.php?editID=<?php echo $row["INTmatid"] ?>"> Edit </a></td>
				    		<td> <a href="../inventorysystem/material_item_delete_formhandler.php?deleteID=<?php echo $row["INTmatid"] ?>"> Delete </a></td>
				    	</tr>
				<?php	}
			echo "</table>";
		}else{
			echo "0 results";
		}
	?>
</body>
</html>