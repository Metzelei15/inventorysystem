<?php include_once ('dbconn.php');

try {
    $query = "SELECT 
        p.STRmatname, 
        l.INTmatstockchange, 
        l.STRaction, 
        l.DTmatdtlog, 
        l.INTmatlogid
    FROM 
        materialstockslog l
    JOIN 
        materialtable p ON l.INTmatid = p.INTmatid";

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
    <title>Material Logs</title>
    <style>
    </style>
</head>
<body>
    <?php if (count($logs) > 0): ?>
        <table>
            <tr>
                <th>Material Name</th>
                <th>Stock Change</th>
                <th>Action</th>
                <th>Date</th>
            </tr>
        <?php foreach ($logs as $row): ?>
            <tr>
                <td><?php echo htmlspecialchars($row['STRmatname']); ?></td>
                <td><?php echo htmlspecialchars($row['INTstockchange']); ?></td>
                <td><?php echo htmlspecialchars($row['STRaction']); ?></td>
                <td><?php echo htmlspecialchars($row['DTmatdtlog']); ?></td>
            </tr>
        <?php endforeach; ?>
        </table>

    <?php else: ?>
        <p>No stock logs found.</p>
    <?php endif; ?>
</body>
</html>