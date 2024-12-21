<?php include_once('dbconn.php')?>
<?php include('product_item_edit_query.php');
	if (isset($_SESSION['role'])){
		if($_SESSION['role']!='admin'){
			echo "<script>alert('Admin Only');</script>";
			echo "<script>document.location.href='staffhomepage.php';</script>";
		}
	}	
?>
<html>
<head>
	<title>Add a new Product</title>
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
	<h2 class="form-header">Add New Item</h2>

	<form action="product_item_edit_formhandler.php" method="POST">
		<input type="hidden" name="INTprodid" value="<?= $INTproductid; ?>">

		<div class="form-group">
			<label for="STRprodname">Product Name</label>
			<input type="text" name="STRprodname" value="<?= $result1->STRprodname; ?>" required><br>
		</div>

		<div class="form-group">
			<label for="STRproddesc">Product Description</label>
			<input type="text" name="STRproddesc" value="<?= $result1->STRproddesc; ?>" required><br>
		</div>

		<button class="submitjm" type="submit" name="product_item_edit">UPDATE</button>
	</form>
</body>
</html>