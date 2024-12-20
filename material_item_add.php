<?php include_once('dbconn.php')?>

<html>
<head>
	<title>New Material Item</title>
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
	<h2 class="form-header">Add New Item</h2>

	<form action="material_item_add_formhandler.php" method="POST">

		<div class="form-group">
			<label for="STRmatname">Material Name</label>
			<input type="text" name="STRmatname" placeholder="Material Name" required><br>
		</div>

		<div class="form-group">
			<label for="STRmatdesc">Material Description</label>
			<textarea name="STRmatdesc" placeholder="Material Description" required></textarea><br>
		</div>

		<button class="submitjm" type="submit">Submit</button>
	</form>

	</div>
	</div>
</body>
</html>