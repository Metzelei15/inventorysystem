<?php
include('dbconn.php');
include_once('session_handling.php');

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

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

    if (isset($_POST['del_product']) && isset($_POST['prodid'])) {
        // Get and sanitize the product ID to delete
        $prodid = (int)$_POST['prodid'];

        // Check if the product exists
        $checkProductQuery = "SELECT 1 FROM `producttable` WHERE `INTprodid` = :prodid LIMIT 1";
        $stmt = $conn->prepare($checkProductQuery);
        $stmt->bindParam(':prodid', $prodid, PDO::PARAM_INT);
        $stmt->execute();

        if ($stmt->rowCount() === 0) {
            echo "<script>alert('Product not found.'); window.location.href='" . $_SERVER['HTTP_REFERER'] . "';</script>";
            exit;
        }

        // Delete the product from the producttable
        $deleteQuery = "DELETE FROM `producttable` WHERE `INTprodid` = :prodid";
        $stmt = $conn->prepare($deleteQuery);
        $stmt->bindParam(':prodid', $prodid, PDO::PARAM_INT);
        $stmt->execute();

        // Log the product deletion into the productremovedtable
        $logQuery = "
            INSERT INTO `productremovedtable` (`INTprodid`, `INTcategoryid`, `INTaccntid`) 
            SELECT `INTprodid`, `INTcategoryid`, :accntid
            FROM `producttable`
            WHERE `INTprodid` = :prodid";
        $stmt = $conn->prepare($logQuery);
        $stmt->bindParam(':prodid', $prodid, PDO::PARAM_INT);
        $stmt->bindParam(':accntid', $accntid, PDO::PARAM_INT);
        $stmt->execute();

        echo "<script>alert('Product deleted and logged successfully!'); window.location.href='" . $_SERVER['HTTP_REFERER'] . "';</script>";
    }
} catch (PDOException $e) {
    // If there's a PDO error, display the error message
    echo "<script>alert('Database error: " . $e->getMessage() . "'); window.location.href='" . $_SERVER['HTTP_REFERER'] . "';</script>";
}
?>
