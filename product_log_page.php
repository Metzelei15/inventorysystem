<?php
require_once 'dbconn.php';

try {
    $query = "SELECT 
              p.STRprodname, 
              l.INTstockchange, 
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
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Product Logs</title>
    <style>
        table, th, td {
            border: 1px solid;
        }
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
                    <td><?php echo htmlspecialchars($row['INTstockchange']); ?></td>
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