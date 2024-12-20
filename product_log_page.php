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
    $stmt->execut
    $logs = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("Query failed: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Product Logs</title>
    <style>
    </style>
</head>
<body>
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
</body>
</html>