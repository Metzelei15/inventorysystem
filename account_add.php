<?php include_once('dbconn.php');
include_once('session_handling.php');
if (isset($_SESSION['role'])){
	if($_SESSION['role']!='admin'){
		echo "<script>alert('Admin Only');</script>";
		echo "<script>document.location.href='staffhomepage.php';</script>";
	}
}
?>
	
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
	<title>Create New Account</title>
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins&display=swap">
    <link rel="stylesheet" href="inventory_style_sheet.css">
</head>
<body>

	<div class="sidebar">
        <div class="logo">Logo</div>
        <ul>
            <li><a href="../inventorysystem/adminhomepage.php">Home</a></li>
            <li><a href="../inventorysystem/productpage.php">Products</a></li>
            <li><a href="../inventorysystem/materialpage.php">Materials</a></li>
            <li><a href="../inventorysystem/reportgeneration.php">Reports</a></li>
            <li><a href="../inventorysystem/accountpage.php">Accounts</a></li>
            <li><a href="#">Logout</a></li>
        </ul>
    </div>

    <div class="main-content-container">
    <div class="main-content">
	<h2 class="form-header">Add Account</h2>

	<form action="account_add_formhandler.php" method="POST">

		<div class="form-group">
			<label for="STRusername">Username</label>
			<input type="text" name="STRusername" required><br>
		</div>

		<div class="form-group">
			<label for="STRpassword">Password</label>
			<input type="password" name="STRpassword" required><br>
		</div>

		<div class="form-group">
			<label for="STRfirstname">Firstname</label>
			<input type="test" name="STRfirstname" required><br>
		</div>

		<div class="form-group">
			<label for="STRlastname">Lastname</label>
			<input type="text" name="STRlastname" required><br>
		</div>

		<div class="form-group">
			<label>Role</label>
			<select name = "INTroleid" required>
				<option >--SELECT CATEGORY--</option>
				<?php foreach ($result1 as $output) { ?>
					<option value="<?php echo$output["INTroleid"]?>"><?php echo$output["STRaccntrole"]?></option>
				<?php }  ?>
			</select>
		</div>
		<button class="submitjm" type="submit">Submit</button>
	</form>
	</div>
	</div>
</body>
</html>