<?php include('dbconn.php') ?>
<!DOCTYPE html>
<html>
<head>
	<title>Product</title>
</head>
<body>
	<?php
		 $query = "SELECT * FROM `producttable`;";
	?>
	<table>
		<tr>
			<th>ID</th>
			<th>Name</th>
			<th>Stock</th>
		</tr>
		<tr>
			<td><?php echo "<p>$query</p>";?></td>
		</tr>
	</table>
</body>
</html>