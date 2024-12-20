<?php include_once ('dbconn.php');

try {
    $query = "SELECT 
        p.STRprodname, 
        l.INTprodstockchange, 
        l.STRaction, 
        l.DTproddtlog, 
        l.INTprodlogid
    FROM 
        productstockslog l
    JOIN 
        producttable p ON l.INTprodid = p.INTprodid";

    $stmt = $conn->prepare($query);
    $stmt->execute();
    $logs = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("Query failed: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Product Logs</title>
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
    <div class="table-container">
        <div class="header-container">
        <span class="header-text">Product Logs</span>
            <div class="button-group">
                <button class="Add-product" onclick="document.location='productpage.php'"> Product List </button>
                <button class="Add-product" onclick="document.location='product_item_add.php'"> Add Product </button>
                <button class="Add-product" onclick="document.location='product_search.php'"> Product Search </button>
                <button class="Add-product" onclick="document.location='product_log_add.php'"> Add New Log </button>
            </div>
        </div>

    <?php if (count($logs) > 0): ?>
        <table>
            <tr>
                <th>Product Name</th>
                <th>Stock Change</th>
                <th>Action</th>
                <th>Date</th>
            </tr>
        <?php foreach ($logs as $row): ?>
            <tr>
                <td><?php echo htmlspecialchars($row['STRprodname']); ?></td>
                <td><?php echo htmlspecialchars($row['INTprodstockchange']); ?></td>
                <td><?php echo htmlspecialchars($row['STRaction']); ?></td>
                <td><?php echo htmlspecialchars($row['DTproddtlog']); ?></td>
            </tr>
        <?php endforeach; ?>
        </table>
        
    <?php else: ?>
        <p>No stock logs found.</p>
    <?php endif; ?>

    </div>
    </div>
</body>
</html>