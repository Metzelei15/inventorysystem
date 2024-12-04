<?php include_once('dbconn.php')?>
<?php include_once('formhandler.php');

	$sql = "SELECT * FROM categorytable";

	try {
		$stmt = $conn->prepare($sql);
		$stmt->execute();
		$result1=$stmt->fetchAll();
	} catch (PDOException $ex) {
		echo($ex->ex.getMessage());
	}

?>
<html>
<head>
	<title>Product Add</title>
</head>
<body>
	<form action="formhandler.php" method="POST">
		<label for="STRprodname">Product Name</label>
		<input type="text" name="STRprodname" required><br>

		<label for="STRproddesc">Product Description</label>
		<input type="text" name="STRproddesc" required><br>

		<!--this is for testing papalitan pa tong part ng select-->
		<label for="INTcategoryid">Category</label>
		<select name = "INTcategoryid" required>
			<option >--SELECT CATEGORY--</option>
			<?php foreach ($result1 as $output) { ?>
				<option value="<?php echo$output["INTcategoryid"]?>"><?php echo$output["STRcategoryname"]?></option>
			<?php }  ?>
		</select>

		<button type="submit">Submit</button>
	</form><br>
</body>
</html>