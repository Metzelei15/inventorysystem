<?php include('dbconn.php') ?>
<!DOCTYPE html>
<html>
<head>
	<title>Product</title>
</head>
<body>
	<?php
		 $query = "SELECT * FROM `Product`;";
	?>
	<table>
		<tr>
			<th>ID</th>
			<th>Name</th>
			<th>Stock</th>
		</tr>
		<tr>
			<td>placeholder1</td>
			<td>placeholder2</td>
			<td>placeholder3</td>
		</tr>
	</table>
</body>
</html>