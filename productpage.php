<?php 
	include('dbconn.php');
	include_once('session_handling.php');
	$isAdmin = isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
?>
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
        <div class="logo"><img src="images/Main_logo_3.png" class="logo-mhaine"></div>
        <ul>
			<li><a href="../inventorysystem/staffhomepage.php">Home</a></li>
            <li><a href="../inventorysystem/productpage.php">Products</a></li>
            <li><a href="../inventorysystem/materialpage.php">Materials</a></li>
            <li><a href="../inventorysystem/reportgeneration.php">Reports</a></li>
            <li><a href="../inventorysystem/accountpage.php">Accounts</a></li>
            <form><button type='submit' name='logout' class="logout-button">Logout</button></form>
        </ul>
    </div>
    <div class="main-content-container">
    <div class="main-content">
	<div class="table-container">
		<div class="header-container">
	    <span class="header-text">Product List</span>
			<div class="button-group">
				<button class="Add-product" onclick="document.location='product_search.php'"> Search Product </button>
			    <button class="Add-product" onclick="document.location='product_item_add.php'"> Add New Product </button>
			    <button class="Add-product" onclick="document.location='product_log_page.php'"> Product Logs </button>
			    <button class="Add-product" onclick="document.location='product_log_add.php'"> Add New log </button>
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
				    		<td> <a href="<?php echo $isAdmin ? '../inventorysystem/product_item_delete_formhandler.php?deleteID=' . $row["INTprodid"] : 'javascript:void(0)'; ?>"class="table-button"<?php echo !$isAdmin ? 'style="pointer-events: none; color: gray;"' : ''; ?>>Delete</a></td>
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