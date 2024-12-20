<?php include_once('dbconn.php')?>
<?php include('material_item_edit_query.php')?>
<html>
<head>
	<title>Add New Material</title>
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins&display=swap">
	<link rel="stylesheet" href = "inventory_style_sheet.css">
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
	<h2 class="form-header">Add New Item</h2>

	<form action="material_item_edit_formhandler.php" method="POST">
		<input type="hidden" name="INTmatid" value="<?= $INTmaterialid; ?>">

		<div class="form-group">
			<label for="STRmatname">Material Name</label>
			<input type="text" name="STRmatname" value="<?= $result1->STRmatname; ?>" required><br>
		</div>

		<div class="form-group">
			<label for="STRmatdesc">Material Description</label>
			<input type="text" name="STRmatdesc" value="<?= $result1->STRmatdesc; ?>" required><br>
		</div>
		
		<button class="submitjm" type="submit" name="material_item_edit">UPDATE</button>
	</form>

	</div>
	</div>
</body>
</html>