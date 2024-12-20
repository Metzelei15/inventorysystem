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
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins&display=swap">
	<link rel = "stylesheet" href = "inventory_style_sheet.css">
</head>
<body>

    <div class="sidebar">
        <div class="logo">Logo</div>
        <ul>
            <li><a href="../inventorysystem/adminhomepage.php">Home</a></li>
            <li><a href="../inventorysystem/productpage.php">Products</a></li>
            <li><a href="../inventorysystem/materialpage.php">Materials</a></li>
            <li><a href="../inventorysystem/reportgeneration.php">Reports</a></li>
            <li><a href="../inventorysystem/accountpage.php">Accounts</a></li>
            <li><a href="#">Logout</a></li>
        </ul>
    </div>

    <div class="main-content-container">
    <div class="main-content">
	<div class="table-container">
		<div class="header-container">
	    <span class="header-text">Product List</span>
			<div class="button-group">
				<button class="Add-product" onclick="document.location='product_search.php'"> Search Product </button>
				<button class="Add-product" onclick="document.location='product_log_add.php'"> Add New log </button>
			    <button class="Add-product" onclick="document.location='product_item_add.php'"> Add New Product </button>
			</div>
		</div>

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
				    		<td> <a href="../inventorysystem/product_item_edit.php?editID=<?php echo $row["INTprodid"] ?> " class="table-button"> Edit </a></td>
				    		<td> <a href="../inventorysystem/product_item_delete_formhandler.php?deleteID=<?php echo $row["INTprodid"] ?>" class="table-button"> Delete </a></td>
				    	</tr>

					<?php }
			echo "</table>";
		}else{
			echo "0 results";
		}
	?>

	</div>
	</div>
	</div>
</body>
</html>