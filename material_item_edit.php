<?php include_once('dbconn.php')?>
<?php include('material_item_edit_query.php')?>
<html>
<head>
	<title>Add a new Material</title>
</head>
<body>
	<form action="material_item_edit_formhandler.php" method="POST">
		<input type="hidden" name="INTmatid" value="<?= $INTmaterialid; ?>">

		<label for="STRmatname">Material Name</label>
		<input type="text" name="STRmatname" value="<?= $result1->STRmatname; ?>" required><br>

		<label for="STRmatdesc">Material Description</label>
		<input type="text" name="STRmatdesc" value="<?= $result1->STRmatdesc; ?>" required><br>

		<button type="submit" name="material_item_edit">UPDATE</button>
	</form>
</body>
</html>