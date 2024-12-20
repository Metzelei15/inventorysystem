<?php include ('dbconn.php');?>
<!DOCTYPE html>
<html>
<head>
	<title>Product Add Log</title>
</head>
<body>
	<form action="product_log_add_formhandler.php" method="POST">

    <label>Product ID:</label>
    <select name="INTprodid" required>
        <?php
	        $query = "SELECT INTprodid, STRprodname FROM producttable";
	        $stmt = $conn->prepare($query);
	        $stmt->execute();
	        $materials = $stmt->fetchAll(PDO::FETCH_ASSOC);

	        foreach ($materials as $material) {
	            echo "<option value='{$material['INTprodid']}'> {$material['STRprodname']}</option>";
	        }
        ?>
    </select><br>

    <label>Stock Change:</label>
    <input type="number" name="INTprodstockchange" required><br>

    <label>Action (Add/Remove):</label>
    <select name="STRaction" required>
        <option value="Add">Add</option>
        <option value="Remove">Remove</option>
    </select><br>

    <button type="submit" >Submit</button>
</form>

</body>
</html>