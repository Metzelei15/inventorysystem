<?php include_once('dbconn.php')?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Add a new Material</title>
</head>
<body>
	<form action="material_item_add_formhandler.php" method="POST">
		<label for="STRmatname">Material Name</label>
		<input type="text" name="STRmatname" required><br>

		<label for="STRmatdesc">Material Description</label>
		<input type="text" name="STRmatdesc" required><br>

		<button type="submit">Submit</button>
	</form>
</body>
</html>