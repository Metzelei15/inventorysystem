<?php 
	include('dbconn.php');
	include_once('session_handling.php');
	$isAdmin = isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
?>
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
	    <span class="header-text">Material List</span>
			<div class="button-group">
				<button class="Add-product" onclick="document.location='material_search.php'"> Search Material </button>
				<button class="Add-product" onclick="document.location='material_item_add.php'"> Add Material </button>
				<button class="Add-product" onclick="document.location='material_log_page.php'"> Material Log </button>
				<button class="Add-product" onclick="document.location='material_log_add.php'"> Add New log </button>
			</div>
		</div>

	<?php
		if($result > 0) {
			echo "<table>
			<tr>
				<th>MATERIAL ID
				</th><th>NAME
				</th><th>DESCRIPTION
				</th><th>QUANTITY
				</th><th>EDIT
				</th><th>DELETE
				</th>
			</tr>";
			
			foreach($result as $row) {?>
			<tr>
			    <td><?php echo htmlspecialchars($row["INTmatid"]); ?></td>
				<td><?php echo htmlspecialchars($row["STRmatname"]); ?></td>
				<td><?php echo htmlspecialchars($row["STRmatdesc"]); ?></td>
				<td><?php echo htmlspecialchars($row["INTmatquan"]); ?></td>
				<td><a href="../inventorysystem/material_item_edit.php?editID=<?php echo $row["INTmatid"] ?>"> Edit </a></td>
				<td> <a href="<?php echo $isAdmin ? '../inventorysystem/material_item_delete_formhandler.php?deleteID=' . $row["INTmatid"] : 'javascript:void(0)'; ?>"class="table-button"<?php echo !$isAdmin ? 'style="pointer-events: none; color: gray;"' : ''; ?>>Delete</a></td>
			</tr>
			<?php	}
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