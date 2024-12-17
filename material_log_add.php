<?php include_once('dbconn.php')?>
<?php include('material_log_add_query.php')?>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Add New Material Stocks</title>
</head>
<body>
	<form action="material_log_add_formhandler.php" method="POST">

		<label>Material Name</label>
		<input type="" name="" required>

		<label>Material Quantity</label>
		<input type="number" name="" required>

		<button type="submit">Submit</button>
	</form>
</body>
</html>