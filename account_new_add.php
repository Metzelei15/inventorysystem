<?php include_once('dbconn.php')?>
<?php 
	$sql = "SELECT * FROM accountroletable";
	try {
		$stmt = $conn->prepare($sql);
		$stmt->execute();
		$result1=$stmt->fetchAll();
	} catch (PDOException $ex) {
		echo($ex->ex.getMessage());
	}

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Add a new Account</title>
</head>
<body>
	<form action="account_add_formhandler.php" method="POST">
		<label for="STRusername">Username</label>
		<input type="text" name="STRusername" required><br>

		<label for="STRpassword">Password</label>
		<input type="password" name="STRpassword" required><br>

		<label for="STRfirstname">Firstname</label>
		<input type="test" name="STRfirstname" required><br>

		<label for="STRlastname">Lastname</label>
		<input type="text" name="STRlastname" required><br>

		<select name = "INTroleid" required>
			<option >--SELECT CATEGORY--</option>
			<?php foreach ($result1 as $output) { ?>
				<option value="<?php echo$output["INTroleid"]?>"><?php echo$output["STRaccntrole"]?></option>
			<?php }  ?>
		</select>

		<button type="submit">Submit</button>
	</form>
</body>
</html>