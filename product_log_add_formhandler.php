<?php
require_once 'dbconn.php';

if (isset($_POST['INTprodid'], $_POST['INTprodstockchange'], $_POST['STRaction'])) {
    $INTprodid = (int)$_POST['INTprodid'];
    $INTprodstockchange = (int)$_POST['INTprodstockchange'];
    $STRaction = $_POST['STRaction'];

    try {
        $conn->beginTransaction();

        $query = "SELECT INTprodquan FROM producttable WHERE INTprodid = :INTprodid LIMIT 1";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':INTprodid', $INTprodid, PDO::PARAM_INT);
        $stmt->execute();
        $product = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$product) {
            throw new Exception("Product not found.");
        }

        $currentStock = (int)$product['INTprodquan'];
        $stockChange = ($STRaction === 'Add') ? $INTprodstockchange : -$INTprodstockchange;
        $newStock = $currentStock + $stockChange;

        if ($newStock < 0) {
            throw new Exception("Stock cannot go below zero.");
        }

        $insertQuery = "INSERT INTO productstockslog (INTprodid, INTprodstockchange, STRaction, DTproddtlog) 
                        VALUES (:INTprodid, :INTprodstockchange, :STRaction, NOW())";
        $insertStmt = $conn->prepare($insertQuery);
        $insertStmt->bindParam(':INTprodid', $INTprodid, PDO::PARAM_INT);
        $insertStmt->bindParam(':INTprodstockchange', $INTprodstockchange, PDO::PARAM_INT);
        $insertStmt->bindParam(':STRaction', $STRaction, PDO::PARAM_STR);
        $insertStmt->execute();

        $updateQuery = "UPDATE producttable SET INTprodquan = :newStock WHERE INTprodid = :INTprodid";
        $updateStmt = $conn->prepare($updateQuery);
        $updateStmt->bindParam(':newStock', $newStock, PDO::PARAM_INT);
        $updateStmt->bindParam(':INTprodid', $INTprodid, PDO::PARAM_INT);
        $updateStmt->execute();

        $conn->commit();
        echo "Stock log added successfully.";
        header("Location: ../inventorysystem/product_log_page.php");

    } catch (Exception $e) {
        $conn->rollBack();
        
        header("Location: ../inventorysystem/product_log_page.php");
        die("Error: " . $e->getMessage());    
    }

} else {
    header("Location: ../inventorysystem/product_log_page.php");
    die("Invalid input.");
}
?>
