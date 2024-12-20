<?php include ('dbconn.php');?>
<!DOCTYPE html>
<html>
<head>
	<title>Product Add Log</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins&display=swap">
    <link rel = "stylesheet" href = "inventory_style_sheet.css">
</head>
<body>

    <div class="sidebar">
        <div class="logo"><img src="images/Main_logo_3.png" class="logo-mhaine"></div>
        <ul>
			<li><a href="../inventorysystem/staffhomepage.php">Home</a></li>
            <li><a href="../inventorysystem/productpage.php">Products</a></li>
            <li><a href="../inventorysystem/materialpage.php">Materials</a></li>
            <li><a href="../inventorysystem/reportgeneration.php">Reports</a></li>
            <li><a href="../inventorysystem/accountpage.php">Accounts</a></li>
            <form><button type='submit' name='logout' class="logout-button">Logout</button></form>
        </ul>
    </div>

    <div class="main-content-container">
    <div class="main-content">

    <h2 class="form-header">Add Product Logs</h2>

	<form action="product_log_add_formhandler.php" method="POST">

    <div class="form-group">
        <label>Product Name</label>
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
    </div>

    <div class="form-group">
        <label>Stock Change</label>
        <input type="number" name="INTprodstockchange" min="1" placeholder="Quantity" required><br>
    </div>

    <div class="form-group">
        <label>Action (Add/Remove)</label>
        <select name="STRaction" required>
            <option value="Add">Add</option>
            <option value="Remove">Remove</option>
        </select><br>
    </div>

    <button class="submitjm" type="submit" >Submit</button>
    </form>

</div>
</div>
</body>
</html>