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
</head>
<body>
    
    <form action="product_search.php" method="GET">
        <label for="search">Search:</label>
        <input type="text" name="search" id="search" value="<?= htmlspecialchars($searchTerm) ?>" placeholder="Enter Product name or description">
        <button type="submit">Search</button>
    </form>

    <?php if (!empty($searchTerm)): ?>
        <h3>Search Results:</h3>
        <?php if ($products): ?>
            <table border="1">
                <tr>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Quantity</th>
                </tr>
                <?php foreach ($products as $row): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['STRprodname']) ?></td>
                        <td><?= htmlspecialchars($row['STRproddesc']) ?></td>
                        <td><?= htmlspecialchars($row['INTprodquan']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php else: ?>
            <p>No results found for '<strong><?= htmlspecialchars($searchTerm) ?></strong>'</p>
        <?php endif; ?>
    <?php endif; ?>
</body>
</html>
