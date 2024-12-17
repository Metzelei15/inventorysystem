<?php
require_once 'dbconn.php';

try {
    $query = "SELECT INTprodid, STRprodname FROM producttable";
    $stmt = $conn->prepare($query);
    $stmt->execute();

    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("Error fetching products: " . $e->getMessage());
}
?>