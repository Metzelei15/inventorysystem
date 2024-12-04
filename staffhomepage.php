<?php 
	include('dbconn.php');
	session_start();

	if (!isset($_SESSION["role"])){
		echo "<script>document.location.href = 'login.php'</script>";
	} else if ($_SESSION["role"]=="admin"){
		echo "<script>document.location.href = 'adminhomepage.php'</script>";
	}

	if (isset($_GET['section'])) {
		echo "You have clicked on the " . $_GET['section'] . " section.";
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Staff Dashboard</title>
	<style>
		:root {
			--primary-green: #04AA6D;
			--primary-green-hover: #038c57;
			--text-color-dark: #333;
			--text-color-light: #fff;
			--border-color: #ddd;
		}

		/* Sidebar Styles */
		ul {
			list-style-type: none;
			margin: 0;
			padding: 0;
			width: 10%;
			background-color: #f1f1f1;
			position: fixed;
			height: 100%;
			overflow: auto;
		}

		li a {
			display: block;
			color: #000;
			padding: 8px 16px;
			text-decoration: none;
		}

		li a.active {
			background-color: var(--primary-green);
			color: var(--text-color-light);
		}

		li a:hover:not(.active) {
			background-color: #555;
			color: var(--text-color-light);
		}

		/* Form Styles */
		form input, form button, input[type='text'], input[type='number'], select {
			margin: 10px 0;
			display: block;
			padding: 8px 16px;
			border: 1px solid var(--border-color);
			border-radius: 4px;
			font-size: 14px;
			color: var(--text-color-dark);
		}

		input[type='text'],
		input[type='number'],
		select {
			width: 100%;
			margin-bottom: 15px;
			background-color: #fff;
		}

		button {
			background-color: var(--primary-green);
			color: var(--text-color-light);
			border: none;
			padding: 10px;
			width: 100%;
			cursor: pointer;
			font-size: 16px;
			border-radius: 4px;
			transition: background-color 0.3s;
		}

		button:hover {
			background-color: var(--primary-green-hover);
		}

		/* Main Content */
		#content {
			margin-left: 12%;
			padding: 10px;
		}

		/* Table Styles */
		table {
			width: 80%;
			border-collapse: collapse;
			margin: 20px auto;
		}

		table th, table td {
			border: 1px solid var(--border-color);
			padding: 8px;
			text-align: center;
		}

		table th {
			background-color: var(--primary-green);
			color: var(--text-color-light);
		}

		/* Form Container to Arrange Forms Side by Side */
		.form-container {
			display: flex;
			gap: 30px;
			margin-top: 30px;
		}

		/* Styling for the Add and Delete Product Boxes */
		.form-box {
			background-color: var(--primary-green);
			border: 1px solid var(--border-color);
			border-radius: 8px;
			padding: 20px;
			width: 45%;
			box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
			color: var(--text-color-light);
		}

		.form-box h2 {
			text-align: center;
		}

		/* Label styling */
		label {
			display: block;
			font-size: 14px;
			margin-bottom: 5px;
			color: var(--text-color-dark);
		}

		/* Responsive Styles for Small Screens */
		@media (max-width: 768px) {
			.form-container {
				flex-direction: column;
				align-items: center;
			}

			.form-box {
				width: 80%;
			}
		}

		.small-button {
			background-color: #04AA6D;
			color: white;
			padding: 5px; 
			font-size: 12px;     
			width: 100px;        
			height: 30px;
			border: none;
			border-radius: 4px;
			cursor: pointer;
			transition: background-color 0.3s;
			display: inline-block;
			margin-right: 10px;
		}

		.small-button:hover {
			background-color: #038c57;
		}

		/* Align the buttons side by side */
		.button-container {
			text-align: center;
		}

	</style>
</head>
<?php
	if (isset($_POST["logout"])){
		session_unset();
		session_destroy();
		echo "<script>document.location.href = 'login.php';</script>";
	}
?>
<body>
    <ul>
        <li>Dashboard</li>
        <li><a href="?section=Product" class="<?= isset($_GET['section']) && $_GET['section'] === 'Product' ? 'active' : '' ?>">Product</a></li>
        <li><a href="?section=Material" class="<?= isset($_GET['section']) && $_GET['section'] === 'Material' ? 'active' : '' ?>">Material</a></li>
        <li><a href="?section=Report" class="<?= isset($_GET['section']) && $_GET['section'] === 'Report' ? 'active' : '' ?>">Report</a></li>
        <form method="POST"><button class="small-button" type="submit" name="logout">Logout</button></form>
    </ul>
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
                        $stmt->bindValue(':search', is_numeric($search) ? $search : "%$search%", PDO::PARAM_STR);
                    }
                    $stmt->execute();

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

							if (isset($search)) {
								try {
									$query = "SELECT `INTmatid`, `STRmatname`, `INTmatquan` FROM `materialtable` WHERE `STRmatname` LIKE :search";
									$stmt = $conn->prepare($query);
							
									// Bind the search term to the placeholder
									$stmt->bindValue(':search', '%' . $search . '%', PDO::PARAM_STR);
				
									$stmt->execute();
									$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
					
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
								} catch (PDOException $e) {
									echo "<tr><td colspan='3'>Error: " . $e->getMessage() . "</td></tr>";
								}
							}

                    echo "</table>";
                    break;

                case 'Report':
                    echo "<div style='text-align: center;'>
                        <button onClick=alert('WalapangReport')>Generate Report</button>
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
	</script>
</body>
</html>
