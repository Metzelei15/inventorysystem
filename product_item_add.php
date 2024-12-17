<?php include_once('dbconn.php')?>

<html>
<head>
	<title>Product Item Add</title>
</head>
<body>
	<form action="product_item_add_formhandler.php" method="POST">
		<label for="STRprodname">Product Name</label>
		<input type="text" name="STRprodname" value="" required><br>

		<label for="STRproddesc">Product Description</label>
		<input type="text" name="STRproddesc" required><br>

		<button type="submit">Submit</button>
	</form>
</body>
</html>