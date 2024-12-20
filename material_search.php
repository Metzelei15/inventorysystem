<?php include('dbconn.php') ?>
<?php

$searchTerm = '';
$materials = [];

if (isset($_GET['search'])) {
    $searchTerm = htmlspecialchars($_GET['search']);
    
    try {
        // Search query with wildcard matching
        $query = "SELECT * FROM materialtable 
                  WHERE STRmatname LIKE :search OR STRmatdesc LIKE :search";
        $stmt = $conn->prepare($query);
        $wildcardSearch = '%' . $searchTerm . '%';
        $stmt->bindParam(':search', $wildcardSearch, PDO::PARAM_STR);
        $stmt->execute();
        $materials = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        die("Error: " . $e->getMessage());
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Search Material</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins&display=swap">
    <link rel = "stylesheet" href = "inventory_style_sheet.css">
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
    <div class="table-container">
        <div class="header-container">
        <span class="header-text">Material List</span>
            <div class="button-group">
                <button class="Add-product" onclick="document.location='materialpage.php'"> Material List </button>
                <button class="Add-product" onclick="document.location='material_item_add.php'"> Add Material </button>
                <button class="Add-product" onclick="document.location='material_log_page.php'"> Material Log </button>
                <button class="Add-product" onclick="document.location='material_log_add.php'"> Add New log </button>
            </div>
        </div>

    <form action="material_search.php" method="GET">

        <div class="search-bar">
        <input type="text" name="search" id="search" value="<?= htmlspecialchars($searchTerm) ?>" placeholder="Enter Material name or description">
        <button type="submit">
            <span class="search-icon">🔍</span>
        </div>
    </form>

    <?php if (!empty($searchTerm)): ?>
        <?php if ($materials): ?>
            <table border="1">
                <tr>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Quantity</th>
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>
                <?php foreach ($materials as $row): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['STRmatname']) ?></td>
                        <td><?= htmlspecialchars($row['STRmatdesc']) ?></td>
                        <td><?= htmlspecialchars($row['INTmatquan']) ?></td>
                        <td><a href="../inventorysystem/material_item_edit.php?editID=<?php echo $row["INTmatid"] ?>"> Edit </a></td>
                        <td><a href="../inventorysystem/material_item_delete_formhandler.php?deleteID=<?php echo $row["INTmatid"] ?>"> Delete </a></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php else: ?>
            <p style="font-family: 'Poppins', sans-serif; font-size: 25px; color: #333;" align="center">No results found for '<strong><?= htmlspecialchars($searchTerm) ?></strong>'</p>
        <?php endif; ?>
    <?php endif; ?>
</body>
</html>
