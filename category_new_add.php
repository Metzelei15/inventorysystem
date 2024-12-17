<?php include_once('dbconn.php')?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Add new a category</title>
</head>
<body>
	<form action="category_new_add_formhandler.php" method="POST">
		<label for="STRcategoryname">Category Name</label>
		<input type="text" name="STRcategoryname" required><br>

		<label for="STRcategorydesc">Category Description</label>
		<input type="text" name="STRcategorydesc" required><br>

		<button type="submit">Submit</button>
	</form>
</body>
</html>