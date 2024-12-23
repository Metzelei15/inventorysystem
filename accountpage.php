<?php include('dbconn.php');
include_once('session_handling.php');
if (isset($_SESSION['role'])){
    if($_SESSION['role']!='admin'){
        echo "<script>alert('Admin Only');</script>";
        echo "<script>document.location.href='staffhomepage.php';</script>";
    }
}
?>

<?php 
	$query = "SELECT * FROM account";
	try {
		$stmt = $conn->prepare($query);
		$stmt->execute();
		$result = $stmt->fetchAll();
	} catch (PDOException $ex) {
		echo "Error: " . $ex->getMessage();
	}
?>
<html>
<head>
	<title>Accounts</title>
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins&display=swap">
	<link rel="stylesheet" href="inventory_style_sheet.css">
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
            <div class="table-container">
                <div class="header-container">
                    <span class="header-text">Accounts List</span>
                    <div class="button-group">
                        <button class="Add-product" onclick="document.location='account_add.php'"> New Account </button>
                    </div>
                </div>

                <?php
                    if (count($result) > 0) {
                        echo "<table>
                        <tr>
                            <th>USERNAME</th>
                            <th>FIRSTNAME</th>
                            <th>LASTNAME</th>
                            <th>EDIT</th>
                            <th>DELETE</th>
                        </tr>";
                        
                        foreach ($result as $row) {
                            echo "<tr>
                                <td>" . htmlspecialchars($row["STRusername"]) . "</td>
                                <td>" . htmlspecialchars($row["STRfirstname"]) . "</td>
                                <td>" . htmlspecialchars($row["STRlastname"]) . "</td>
                                <td><a href='account_edit.php?editID=" . $row["INTaccntid"] . "'> Edit </a></td>
                                <td><a href='account_delete_formhandler.php?deleteID=" . $row["INTaccntid"] . "'> Delete </a></td>
                            </tr>";
                        }
                        echo "</table>";
                    } else {
                        echo "No accounts found.";
                    }
                ?>

            </div>
        </div>
    </div>
</body>
</html>