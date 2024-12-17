<?php include('dbconn.php')?>
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
					</th><th>EDIT
					</th><th>DELETE
					</th></tr>";
					// output data of each row
					foreach($result as $row) {?>
				    	<tr>
				    		<td><?php echo htmlspecialchars($row["INTprodid"]); ?></td>
		                    <td><?php echo htmlspecialchars($row["STRprodname"]); ?></td>
		                    <td><?php echo htmlspecialchars($row["STRproddesc"]); ?></td>
		                    <td><?php echo htmlspecialchars($row["INTprodquan"]); ?></td>
				    		<td> <a href="../inventorysystem/product_item_edit.php?editID=<?php echo $row["INTprodid"] ?>"> Edit </a></td>
				    		<td> <a href="../inventorysystem/product_item_delete_formhandler.php?deleteID=<?php echo $row["INTprodid"] ?>"> Delete </a></td>
				    	</tr>

					<?php }
			echo "</table>";
		}else{
			echo "0 results";
		}
	?>
</body>
</html>