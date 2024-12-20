<?php include ('dbconn.php');?>
<!DOCTYPE html>
<html>
<head>
	<title>Material  Add Log</title>
</head>
<body>
	<form action="material_log_add_formhandler.php" method="POST">

    <label>Product ID:</label>
    <select name="INTmatid" required>
        <?php
	        $query = "SELECT INTmatid, STRmatname FROM materialtable";
	        $stmt = $conn->prepare($query);
	        $stmt->execute();
	        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

	        foreach ($products as $row) {
	            echo "<option value='{$row['INTmatid']}'>{$row['STRmatname']}</option>";
	        }
        ?>
    </select><br>

    <label>Stock Change:</label>
    <input type="number" name="INTstockchange" required><br>

    <label>Action (Add/Remove):</label>
    <select name="STRaction" required>
        <option value="Add">Add</option>
        <option value="Remove">Remove</option>
    </select><br>

    <button type="submit"> Submit </button>
</form>

</body>
</html>