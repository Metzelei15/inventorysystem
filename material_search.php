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
</head>
<body>
    <!-- Search Bar -->
    <form action="material_search.php" method="GET">
        <label for="search">Search:</label>
        <input type="text" name="search" id="search" value="<?= htmlspecialchars($searchTerm) ?>" placeholder="Enter Material name or description">
        <button type="submit">Search</button>
    </form>

    <?php if (!empty($searchTerm)): ?>
        <h3>Search Results:</h3>
        <?php if ($materials): ?>
            <table border="1">
                <tr>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Quantity</th>
                </tr>
                <?php foreach ($materials as $row): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['STRmatname']) ?></td>
                        <td><?= htmlspecialchars($row['STRmatdesc']) ?></td>
                        <td><?= htmlspecialchars($row['INTmatquan']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php else: ?>
            <p>No results found for '<strong><?= htmlspecialchars($searchTerm) ?></strong>'</p>
        <?php endif; ?>
    <?php endif; ?>
</body>
</html>
