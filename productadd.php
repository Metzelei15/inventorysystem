<?php include('dbconn.php')?>
<?php include('formhandler.php')?>
<!DOCTYPE html>
<html>
<head>
	<title>Product Add</title>
</head>
<body>
	<form action="inventorysystem/formhandler.php" method="POST">
		<label for="STRprodname">Product Name</label>
		<input type="text" name="STRprodname" required><br>

		<label for="STRproddesc">Product Description</label>
		<input type="text" name="STRproddesc" required><br>

		<!--this is for testing papalitan pa tong part ng select-->
		<label for="INTcategoryid">Category</label>
		<select name = "INTcategoryid" required>
			<option value="1">perfume</option>
		</select>

		<button type="submit">Submit</button>
	</form><br>
</body>
</html>