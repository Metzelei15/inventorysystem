<?php include_once('dbconn.php')?>
<?php include('product_item_edit_query.php')?>
<html>
<head>
	<title>Add a new Product</title>
</head>
<body>
	<form action="product_item_edit_formhandler.php" method="POST">
		<input type="hidden" name="INTprodid" value="<?= $INTproductid; ?>">

		<label for="STRprodname">Product Name</label>
		<input type="text" name="STRprodname" value="<?= $result1->STRprodname; ?>" required><br>

		<label for="STRproddesc">Product Description</label>
		<input type="text" name="STRproddesc" value="<?= $result1->STRproddesc; ?>" required><br>

		<button type="submit" name="product_item_edit">UPDATE</button>
	</form>
</body>
</html>