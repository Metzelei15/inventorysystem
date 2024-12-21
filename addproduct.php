<?php
include('dbconn.php');
include_once('session_handling.php');

$accntid = isset($_SESSION['accntid']) ? $_SESSION['accntid'] : null;

if (!$accntid) {
    echo "<script>alert('Invalid account ID. Please login again.'); window.location.href='login.php';</script>";
    exit;
}

try {
    // Check if the account ID exists
    $checkAccntQuery = "SELECT 1 FROM `account` WHERE `INTaccntid` = :accntid LIMIT 1";
    $stmt = $conn->prepare($checkAccntQuery);
    $stmt->bindParam(':accntid', $accntid, PDO::PARAM_INT);
    $stmt->execute();

    if ($stmt->rowCount() === 0) {
        echo "<script>alert('Account ID does not exist.'); window.location.href='login.php';</script>";
        exit;
    }

    if (isset($_POST['add_product'])) {
        // Get and sanitize input values
        $prodname = $_POST['prodname'];
        $productdesc = $_POST['proddesc'];
        $prodquan = (int)$_POST['prodquan'];
        $categoryid = (int)$_POST['categoryid'];

        // Insert the product
        $insertQuery = "
            INSERT INTO `producttable` (`STRprodname`, `STRproddesc`, `INTprodquan`, `INTcategoryid`) 
            VALUES (:prodname, :proddesc, :prodquan, :categoryid)";
        $stmt = $conn->prepare($insertQuery);
        $stmt->bindParam(':prodname', $prodname, PDO::PARAM_STR);
        $stmt->bindParam(':proddesc', $productdesc, PDO::PARAM_STR);
        $stmt->bindParam(':prodquan', $prodquan, PDO::PARAM_INT);
        $stmt->bindParam(':categoryid', $categoryid, PDO::PARAM_INT);
        $stmt->execute();

        // Get the last inserted product ID
        $prodid = $conn->lastInsertId();

        // Log the product addition
        $logQuery = "
            INSERT INTO `productaddedtable` (`INTprodid`, `INTcategoryid`, `INTaccntid`) 
            VALUES (:prodid, :categoryid, :accntid)";
        $stmt = $conn->prepare($logQuery);
        $stmt->bindParam(':prodid', $prodid, PDO::PARAM_INT);
        $stmt->bindParam(':categoryid', $categoryid, PDO::PARAM_INT);
        $stmt->bindParam(':accntid', $accntid, PDO::PARAM_INT);
        $stmt->execute();

        echo "<script>alert('Product added and logged successfully!'); window.location.href='" . $_SERVER['HTTP_REFERER'] . "';</script>";
    }
} catch (PDOException $e) {
    echo "<script>alert('Database error: " . $e->getMessage() . "'); window.location.href='" . $_SERVER['HTTP_REFERER'] . "';</script>";
}
?>