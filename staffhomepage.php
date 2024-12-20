<?php 
	include('dbconn.php');
	include_once('session_handling.php');
	if ($_SESSION["role"]!="staff"){
		header("Location: login.php");
		session_unset();
		session_destroy();
	}
	if (isset($_GET['section'])) {
		echo "You have clicked on the " . $_GET['section'] . " section.";
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Staff Dashboard</title>
	<link rel ="stylesheet" href="inventory_style_sheet.css">
</head>
<?php
	if (isset($_POST["logout"])){
		session_unset();
		session_destroy();
		echo "<script>document.location.href = 'login.php';</script>";
	}
?>
<body>
<div class="sidebar">
        <div class="logo"><img src="images/Main_logo_2.png" class="logo-mhaine"></div>
        <ul>
            <li><a href="../inventorysystem/adminhomepage.php">Home</a></li>
            <li><a href="../inventorysystem/productpage.php">Products</a></li>
            <li><a href="../inventorysystem/materialpage.php">Materials</a></li>
            <li><a href="../inventorysystem/reportgeneration.php">Reports</a></li>
            <li><a href="../inventorysystem/accountpage.php">Accounts</a></li>
            <li><a href="#">Logout</a></li>
        </ul>
    </div>
    <div id="content">
        <?php
        include('dbconn.php');

        if (isset($_GET['section'])) {
            switch ($_GET['section']) {
                case 'Product':
					$search = isset($_GET['search']) ? trim($_GET['search']) : '';
					$query = "SELECT `INTprodid`, `STRprodname`, `STRproddesc`, `INTprodquan` FROM `producttable`";
					
					if ($search !== '') {
						if (is_numeric($search)) {
							$query .= " WHERE `INTprodid` = :search";
						} else {
							$query .= " WHERE `STRprodname` LIKE :search";
						}
					}
				
					$stmt = $conn->prepare($query);
					if ($search !== '') {
						$stmt->bindValue(':search', is_numeric($search) ? $search : "%$search%", PDO::PARAM_STR);
					}
					$stmt->execute();
				
					echo "
						<form method='GET' style='text-align: center;'>
							<input type='hidden' name='section' value='Product'>
							<input type='text' id='search' name='search' value='" . htmlspecialchars($search) . "' placeholder='Enter Product ID or Name'>
							<button class='small-button' type='submit'>Search</button>
						</form>";
				
					echo "<table>
							<tr>
								<th>ID</th>
								<th>Name</th>
								<th>Description</th>
								<th>Stock</th>
							</tr>";
				
					$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
					if (count($results) > 0) {
						foreach ($results as $row) {
							echo "
								<tr>
									<td>" . htmlspecialchars($row['INTprodid']) . "</td>
									<td>" . htmlspecialchars($row['STRprodname']) . "</td>
									<td>" . htmlspecialchars($row['STRproddesc']) . "</td>
									<td>" . htmlspecialchars($row['INTprodquan']) . "</td>
								</tr>";
						}
					} else {
						echo "<tr><td colspan='4'>" . ($search !== '' ? "No results found for <strong>" . htmlspecialchars($search) . "</strong>" : "No products found") . "</td></tr>";
					}
				
					echo "</table>";
					echo "
						<div class='button-container'>
							<button type='button' class='small-button' onclick='toggleForm(\"addProductForm\")'>Add Product Form</button>
							<button type='button' class='small-button' onclick='toggleForm(\"deleteProductForm\")'>Delete Product Form</button>
						</div>";
					//Add Product Form
					echo "
						<div class='form-container'>
							<div id='addProductForm' style='display: none;'>
								<h3>Add New Product</h3>
								<form method='POST' action='addproduct.php'>
									<label for='prodname'>Product Name:</label>
									<input type='text' id='prodname' name='prodname' required><br><br>
									
									<label for='proddesc'>Description:</label>
									<input type='text' id='proddesc' name='proddesc' required><br><br>
									
									<label for='prodquan'>Quantity:</label>
									<input type='number' id='prodquan' name='prodquan' required><br><br>
									
									<label for='categoryid'>Category:</label>
									<select id='categoryid' name='categoryid' required>";
				
					//Fetching categories for the dropdown
					$catQuery = "SELECT `INTcategoryid`, `STRcategoryname` FROM `categorytable`";
					$catStmt = $conn->prepare($catQuery);
					$catStmt->execute();
					$categories = $catStmt->fetchAll(PDO::FETCH_ASSOC);
					
					foreach ($categories as $cat) {
						echo "		<option value='" . $cat['INTcategoryid'] . "'>" . htmlspecialchars($cat['STRcategoryname']) . "</option>";
					}
				
					echo "
									</select><br><br>
									<button type='submit' class='small-button' name='add_product'>Add Product</button>
								</form>
							</div>";
					// Delete Product Form
					echo "
							<div id='deleteProductForm' style='display: none;'>
								<h3>Delete Product</h3>
								<form method='POST' action='deleteproduct.php'>
									<label for='prodid'>Product ID:</label>
									<input type='number' id='prodid' name='prodid' required><br><br>
									
									<label for='categoryid'>Category:</label>
									<select id='categoryid' name='categoryid' required>";

					$catQuery = "SELECT `INTcategoryid`, `STRcategoryname` FROM `categorytable`";
					$catStmt = $conn->prepare($catQuery);
					$catStmt->execute();
					$categories = $catStmt->fetchAll(PDO::FETCH_ASSOC);

					foreach ($categories as $cat) {
						echo "
									<option value='" . $cat['INTcategoryid'] . "'>" . htmlspecialchars($cat['STRcategoryname']) . "</option>";
							}
					echo "
									</select><br><br>
									<button type='submit' class='small-button' name='del_product'>Delete Product</button>
								</form>
							</div>
						</div>";
					break;

                case 'Material':
                    $search = isset($_GET['search']) ? trim($_GET['search']) : '';
					$query = "SELECT `INTmatid`, `STRmatname`, `INTmatquan` FROM `materialtable`";

					if ($search !== '') {
						if (is_numeric($search)) {
							$query .= " WHERE `INTmatid` = :search";
						} else {
							$query .= " WHERE `STRmatname` LIKE :search";
						}
					}

					$stmt = $conn->prepare($query);
					if ($search !== '') {
						if (is_numeric($search)) {
							$stmt->bindValue(':search', (int)$search, PDO::PARAM_INT);
						} else {
							$stmt->bindValue(':search', "%$search%", PDO::PARAM_STR);
						}
					}

					$stmt->execute();
					$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

					echo "
						<form method='GET' style='text-align: center;'>
							<input type='hidden' name='section' value='Material'>
							<input type='text' id='search' name='search' value='" . htmlspecialchars($search) . "' placeholder='Enter Material ID or Name'>
							<button class='small-button' type='submit'>Search</button>
						</form>";

					echo "<table>
							<tr>
								<th>ID</th>
								<th>Name</th>
								<th>Stock</th>
							</tr>";

					if (count($results) > 0) {
						foreach ($results as $row) {
							echo "
								<tr>
									<td>" . htmlspecialchars($row['INTmatid']) . "</td>
									<td>" . htmlspecialchars($row['STRmatname']) . "</td>
									<td>" . htmlspecialchars($row['INTmatquan']) . "</td>
								</tr>";
						}
					} else {
						echo "<tr><td colspan='3'>" . ($search !== '' ? "No results found for <strong>" . htmlspecialchars($search) . "</strong>" : "No materials found") . "</td></tr>";
					}

					echo "</table>";
                    break;

                case 'Report':
                    echo "<div style='text-align: center;'>
					<form action='reportgeneration.php' method='GET'>
                        <input type='submit' name='report' value='Today'>
            			<input type='submit' name='report' value='Week'>
           		 		<input type='submit' name='report' value='Month'>
					</form>
                    </div>";
                    break;

                default:
                    echo "Please select a section.";
            }
        }
        ?>
    </div>

    <script>
		function toggleForm(formId) {
			var form = document.getElementById(formId);
			if (form.style.display === 'none' || form.style.display === '') {
				form.style.display = 'block';  // Show the form
			} else {
				form.style.display = 'none';  // Hide the form
			}
		}

		function generateReportForm(){
			document.location.href = "reportgeneration.php";
		}
	</script>
</body>
</html>
