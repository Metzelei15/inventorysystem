<?php
require_once 'dbconn.php';
include_once('session_handling.php');

if (isset($_POST['INTmatid'], $_POST['INTmatstockchange'], $_POST['STRaction'])) {
    $INTmatid = (int)$_POST['INTmatid'];
    $INTmatstockchange = (int)$_POST['INTmatstockchange'];
    $STRaction = $_POST['STRaction'];
    $INTaccntid = $_SESSION["accntid"];

    try {
        $conn->beginTransaction();

        $query = "SELECT INTmatquan FROM materialtable WHERE INTmatid = :INTmatid LIMIT 1";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':INTmatid', $INTmatid, PDO::PARAM_INT);
        $stmt->execute();
        $material = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$material) {
            throw new Exception("Material not found.");
        }

        $currentStock = (int)$material['INTmatquan'];
        $stockChange = ($STRaction === 'Add') ? $INTmatstockchange : -$INTmatstockchange;
        $newStock = $currentStock + $stockChange;

        if ($newStock < 0) {
            throw new Exception("Stock cannot go below zero.");
        }

        $insertQuery = "INSERT INTO materialstockslog (INTmatid, INTmatstockchange, STRaction, DTmatdtlog, INTaccntid) 
                        VALUES (:INTmatid, :INTmatstockchange, :STRaction, NOW(), :INTaccntid)";
        $insertStmt = $conn->prepare($insertQuery);
        $insertStmt->bindParam(':INTmatid', $INTmatid, PDO::PARAM_INT);
        $insertStmt->bindParam(':INTmatstockchange', $INTmatstockchange, PDO::PARAM_INT);
        $insertStmt->bindParam(':STRaction', $STRaction, PDO::PARAM_STR);
        $insertStmt->bindParam(':INTaccntid', $INTaccntid, PDO::PARAM_INT);
        $insertStmt->execute();

        $updateQuery = "UPDATE materialtable SET INTmatquan = :newStock WHERE INTmatid = :INTmatid";
        $updateStmt = $conn->prepare($updateQuery);
        $updateStmt->bindParam(':newStock', $newStock, PDO::PARAM_INT);
        $updateStmt->bindParam(':INTmatid', $INTmatid, PDO::PARAM_INT);
        $updateStmt->execute();

        $conn->commit();
        header("Location: ../inventorysystem/material_log_page.php?status=success");
        exit;

    } catch (Exception $e) {
        $conn->rollBack();
        die("Error: " . $e->getMessage());   
    }

} else {
    header("Location: ../inventorysystem/material_log_page.php?status=invalid_input");
    die("Invalid input.");
}
?>
