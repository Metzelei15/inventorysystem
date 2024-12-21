<?php 
    include('dbconn.php');
    include_once('session_handling.php');

    $totalMaterialsQuery = $conn->prepare("SELECT COUNT(*) AS total_materials FROM materialtable");
    $totalMaterialsQuery->execute();
    $totalMaterials = $totalMaterialsQuery->fetch(PDO::FETCH_ASSOC)['total_materials'];

    $totalProductsQuery = $conn->prepare("SELECT COUNT(*) AS total_products FROM producttable");
    $totalProductsQuery->execute();
    $totalProducts = $totalProductsQuery->fetch(PDO::FETCH_ASSOC)['total_products'];

    $lowStockMaterialsQuery = $conn->prepare("SELECT STRmatname, INTmatquan FROM materialtable WHERE INTmatquan < 10");
    $lowStockMaterialsQuery->execute();
    $lowStockMaterials = $lowStockMaterialsQuery->fetchAll(PDO::FETCH_ASSOC);

    $lowStockProductsQuery = $conn->prepare("SELECT STRprodname, INTprodquan FROM producttable WHERE INTprodquan < 10");
    $lowStockProductsQuery->execute();
    $lowStockProducts = $lowStockProductsQuery->fetchAll(PDO::FETCH_ASSOC);

    $materialStocksQuery = $conn->prepare("SELECT STRmatname, INTmatquan FROM materialtable");
    $materialStocksQuery->execute();
    $materialStocks = $materialStocksQuery->fetchAll(PDO::FETCH_ASSOC);

    $productStocksQuery = $conn->prepare("SELECT STRprodname, INTprodquan FROM producttable");
    $productStocksQuery->execute();
    $productStocks = $productStocksQuery->fetchAll(PDO::FETCH_ASSOC);

    $conn = null;

    $materialChartData = [
        'labels' => [],
        'quantities' => [],
    ];

    foreach ($materialStocks as $material) {
        $materialChartData['labels'][] = htmlspecialchars($material['STRmatname']);
        $materialChartData['quantities'][] = (int)$material['INTmatquan'];
    }

    $productChartData = [
        'labels' => [],
        'quantities' => [],
    ];

    foreach ($productStocks as $product) {
        $productChartData['labels'][] = htmlspecialchars($product['STRprodname']);
        $productChartData['quantities'][] = (int)$product['INTprodquan'];
    }
?>
<!DOCTYPE html>
<html>
<head>
    <title>Staff Dashboard</title>
    <link rel="stylesheet" href="inventory_style_sheet.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins&display=swap">
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

    <div id="content" class="stats">
        <div class="card">
            <h2>Total Materials</h2>
            <p><?= htmlspecialchars($totalMaterials); ?></p>
        </div>
        <hr>
        <div class="card">
            <h2>Total Products</h2>
            <p><?= htmlspecialchars($totalProducts); ?></p>
        </div>
        <hr>

        <h2>Low Stock Items</h2>
        <div class="low-stock">
            <h3>Materials</h3>
            <ul class="ul-material">
                <?php foreach ($lowStockMaterials as $material): ?>
                    <li><?= htmlspecialchars($material['STRmatname']) ?> - Quantity: <?= htmlspecialchars($material['INTmatquan']) ?></li>
                <?php endforeach; ?>
            </ul>
            <h3>Products</h3>
            <ul class="ul-product">
                <?php foreach ($lowStockProducts as $product): ?>
                    <li><?= htmlspecialchars($product['STRprodname']) ?> - Quantity: <?= htmlspecialchars($product['INTprodquan']) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>

        <hr>
        <h2>Product Stock Levels</h2>
        <canvas id="productStockChart"></canvas>
        <h2>Material Stock Levels</h2>
        <canvas id="materialStockChart"></canvas>
        <hr>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const materialChartData = <?php echo json_encode($materialChartData); ?>;
        const materialCtx = document.getElementById('materialStockChart').getContext('2d');
        const materialStockChart = new Chart(materialCtx, {
            type: 'bar',
            data: {
                labels: materialChartData.labels,
                datasets: [{
                    label: 'Material Stock Quantity',
                    data: materialChartData.quantities,
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        const productChartData = <?php echo json_encode($productChartData); ?>;
        const productCtx = document.getElementById('productStockChart').getContext('2d');
        const productStockChart = new Chart(productCtx, {
            type: 'bar',
            data: {
                labels: productChartData.labels,
                datasets: [{
                    label: 'Product Stock Quantity',
                    data: productChartData.quantities,
                    backgroundColor: 'rgba(153, 102, 255, 0.2)',
                    borderColor: 'rgba(153, 102, 255, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
</body>
</html>
