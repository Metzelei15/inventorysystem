<?php include_once('dbconn.php')?>
<?php include('material_item_edit_query.php');
include_once('session_handling.php');
if (isset($_SESSION['role'])){
	if($_SESSION['role']!='admin'){
		echo "<script>alert('Admin Only');</script>";
		echo "<script>document.location.href='staffhomepage.php';</script>";
	}
}	
?>
<html>
<head>
	<title>Add New Material</title>
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins&display=swap">
	<link rel="stylesheet" href = "inventory_style_sheet.css">
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