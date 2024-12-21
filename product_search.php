<?php include('dbconn.php') ?>
<?php

$searchTerm = '';
$products = [];

if (isset($_GET['search'])) {
    $searchTerm = htmlspecialchars($_GET['search']);
    
    try {
        $query = "SELECT * FROM producttable 
                  WHERE STRprodname LIKE :search OR STRproddesc LIKE :search";
        $stmt = $conn->prepare($query);
        $wildcardSearch = '%' . $searchTerm . '%';
        $stmt->bindParam(':search', $wildcardSearch, PDO::PARAM_STR);
        $stmt->execute();
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        die("Error: " . $e->getMessage());
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Search Products</title>
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
        <span class="header-text">Product List</span>
            <div class="button-group">
                <button class="Add-product" onclick="document.location='productpage.php'"> Product List </button>
                <button class="Add-product" onclick="document.location='product_item_add.php'"> Add Product </button>
                <button class="Add-product" onclick="document.location='product_log_page.php'"> Product Log </button>
                <button class="Add-product" onclick="document.location='product_log_add.php'"> Add New Lodg </button>
            </div>
        </div>

    <form action="product_search.php" method="GET">

        <div class="search-bar">
            <input type="text" name="search" id="search" value="<?= htmlspecialchars($searchTerm) ?>" placeholder="Enter Product name or description">
            <button type="submit">
                <span class="search-icon">🔍</span>
        </div>

    </form>

    <?php if (!empty($searchTerm)): ?>
        <?php if ($products): ?>
            <table border="1">
                <tr>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Quantity</th>
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>
                <?php foreach ($products as $row): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['STRprodname']) ?></td>
                        <td><?= htmlspecialchars($row['STRproddesc']) ?></td>
                        <td><?= htmlspecialchars($row['INTprodquan']) ?></td>
                        <td> <a href="../inventorysystem/product_item_edit.php?editID=<?php echo $row["INTprodid"] ?> " class="table-button"> Edit </a></td>
                        <td> <a href="../inventorysystem/product_item_delete_formhandler.php?deleteID=<?php echo $row["INTprodid"] ?>" class="table-button"> Delete </a></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php else: ?>

            <p style="font-family: 'Poppins', sans-serif; font-size: 25px; color: #333;" align="center">No results found for '<strong><?= htmlspecialchars($searchTerm) ?></strong>'</p>

        <?php endif; ?>
    <?php endif; ?>
    </div>
    </div>
</body>
</html>
