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

    $chartData = [
        'labels' => [],
        'materialQuantities' => [],
        'productQuantities' => [],
    ];

    foreach ($materialStocks as $material) {
        $chartData['labels'][] = htmlspecialchars($material['STRmatname']);
        $chartData['materialQuantities'][] = (int)$material['INTmatquan'];
    }

    foreach ($productStocks as $product) {
        $chartData['labels'][] = htmlspecialchars($product['STRprodname']);
        $chartData['productQuantities'][] = (int)$product['INTprodquan'];
    }
?>
<!DOCTYPE html>
<html>
<head>
    <title>Staff Dashboard</title>
    <link rel ="stylesheet" href="inventory_style_sheet.css">
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

    </ul>
</div>
<div id="content" class="stats">
    <div>
        <div class="card">
            <h2>Total Materials</h2>
            <p><?= htmlspecialchars($totalMaterials); ?></p>
        </div>
        <div class="card">
            <h2>Total Products</h2>
            <p><?= htmlspecialchars($totalProducts); ?></p>
        </div>
    </div>

    <h2>Low Stock Items</h2>
    <div class="low-stock">
        <h3>Materials</h3>
        <ul>
            <?php foreach ($lowStockMaterials as $material): ?>
                <li><?= htmlspecialchars($material['STRmatname']) ?> - Quantity: <?= htmlspecialchars($material['INTmatquan']) ?></li>
            <?php endforeach; ?>
        </ul>
        <h3>Products</h3>
        <ul>
            <?php foreach ($lowStockProducts as $product): ?>
                <li><?= htmlspecialchars($product['STRprodname']) ?> - Quantity: <?= htmlspecialchars($product['INTprodquan']) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>

    <h2>Stock Levels</h2>
    <canvas id="stockChart"></canvas>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const chartData = <?php echo json_encode($chartData); ?>;
        const ctx = document.getElementById('stockChart').getContext('2d');
        const stockChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: chartData.labels,
                datasets: [{
                    label: 'Material Stock Quantity',
                    data: chartData.materialQuantities,
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }, {
                    label: 'Product Stock Quantity',
                    data: chartData.productQuantities,
                    backgroundColor: 'rgba(153, 102, 255, 0.2)',
                    borderColor: 'rgba(153, 102, 255, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
						min: 0, 
                   	 	max: 1000,
                    }
                }
            }
        });
    </script>
</body>
</html>
